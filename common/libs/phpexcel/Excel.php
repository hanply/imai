<?php
namespace phpexcel;
require(ROOT_PATH.'extend/phpexcel/PHPExcel/PHPExcel.php');
class Excel
{
	private $letter = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD'];
	//错误返回信息
	private $_error = array();

	private $error = array(
		0 => array('code' => 31, 'msg'  => '文件不存在'),
		1 => array('code' => 32, 'msg'  => 'excel文件不存在'),
		2 => array('code' => 33, 'msg'  => 'sheet表格不存在'),
		3 => array('code' => 34, 'msg'  => 'excel读取内容不存在'),
		4 => array('code' => 35, 'msg'  => 'start_row参数有误'),
		5 => array('code' => 36, 'msg'  => 'column参数有误'),
		6 => array('code' => 37, 'msg'  => 'keys参数有误'),
		7 => array('code' => 38, 'msg'  => 'sheet参数有误'),
	);
	/**
	 * 读取excel的内容
	 * @param string $filePath    excel的路径
	 * @param int $start_row   从第几行开始读取
	 * @param int $column   读取excel的列数
	 * @param array $keys   写入数组的键值
	 * @param int $sheet
	 * @return array|void   返回数组
	 */
	public function read($filePath='', $start_row=2, $column=3, $keys=array(), $sheet=0){
		if(self::checkParams($filePath, $start_row, $column, $keys, $sheet)){
			$currentSheet = self::getCurrentSheet($filePath, $sheet);
//		$allColumn    = $currentSheet->getHighestColumn();        //**取得最大的列号*/
			$allRow       = $currentSheet->getHighestRow();        //**取得一共有多少行*/
			if($start_row>$allRow){
				$this->_error = $this->error[3];
				return false;
			}
			$data = array();
			for($rowIndex=$start_row; $rowIndex<=$allRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
				for($colIndex=0;$colIndex<$column;$colIndex++){
					$addr = $this->letter[$colIndex].$rowIndex;
					$cell = $currentSheet->getCell($addr)->getValue();
					if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
						$cell = $cell->__toString();
					}
					if(!empty($keys)){
						if(isset($keys[$colIndex])){
							$k = $keys[$colIndex];
						}else{
							$this->_error = $this->error[6];
							return false;
						}
					}else $k = $currentSheet->getCell($this->letter[$colIndex].'1')->getValue();
					$data[$rowIndex-$start_row][$k] = $cell;
				}
			}
			return $data;
		}
	}
	
	/**
	 * 写入excel
	 * @param  [type] $data  数据
	 * @param  [type] $tarr  表格title
	 * @param  [type] $trows title的行数
	 * @param  [type] $tcols title的列数
	 * @return [type]        [description]
	 */
	public function write($data, $start_row=0, $filePath=null, $sheet=0)
	{
		$PHPReader = new \PHPExcel_Reader_Excel2007();        //建立reader对象
		if(!$PHPReader->canRead($filePath)){
			$PHPReader = new \PHPExcel_Reader_Excel5();
			if(!$PHPReader->canRead($filePath)){
				$this->_error = $this->error[1];
				return false;
			}
		}
		$PHPExcel = $PHPReader->load($filePath);        //建立excel对象
		$currentSheet = $PHPExcel->getSheet($sheet);        //**读取excel文件中的指定工作表*/

		if(!$currentSheet){
			$this->_error = $this->error[2];
			return false;
		}
		if(!empty($data)){
			foreach ($data as $k => $v) {
                $v = array_values($v);
				foreach ($v as $key => $val) {
					$start_index = $this->letter[$key].$start_row;
					$currentSheet->setCellValue($start_index, $val);
				}
				$start_row++;
			}
		}
		$name = time().'.'.($this->getExt($filePath));
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        $objWriter->save('php://output');
	}

	/**校验传参
	 * @param $filePath
	 * @param $start_row
	 * @param $column
	 * @param $keys
	 * @param $sheet
	 * @return bool
	 */
	private function checkParams($filePath, $start_row, $column, $keys, $sheet){
		if(empty($filePath) or !file_exists($filePath)){
			$this->_error = $this->error[0];
			return false;
		}
		if($start_row<1 || !is_int($start_row)){
			$this->_error = $this->error[4];
			return false;
		}
		if($column<1 || !is_int($column)){
			$this->_error = $this->error[5];
			return false;
		}
		if(!empty($keys)){
			if(!is_array($keys) || count($keys)<$column){
				$this->_error = $this->error[6];
				return false;
			}
		}
		if($sheet<0 || !is_int($sheet)){
			$this->_error = $this->error[7];
			return false;
		}
		return true;
	}
	/**
     * 取得上传文件的后缀
     * @access private
     * @param string $realname 文件名
     * @return boolean
     */
    private function getExt($realname) {
        $pathinfo = pathinfo($realname);
        return strtolower($pathinfo['extension']);
    }

    /**
     * 获取当前sheet
     * @param  [type]  $filePath excel的路径
     * @param  integer $sheet    sheet的index
     * @return [type]            当前sheet对象
     */
    private function getCurrentSheet($filePath, $sheet=0)
    {
    	$PHPReader = new \PHPExcel_Reader_Excel2007();        //建立reader对象
		if(!$PHPReader->canRead($filePath)){
			$PHPReader = new \PHPExcel_Reader_Excel5();
			if(!$PHPReader->canRead($filePath)){
				$this->_error = $this->error[1];
				return false;
			}
		}
		$PHPExcel = $PHPReader->load($filePath);        //建立excel对象
		$currentSheet = $PHPExcel->getSheet($sheet);        //**读取excel文件中的指定工作表*/
		if(!$currentSheet){
			$this->_error = $this->error[2];
			return false;
		}
		return $currentSheet;
    }

	/**
	 * 错误返回函数
	 * @return array
	 */
	public function getError()
	{
		return $this->_error;
	}

	public function getCells($index)
	{
		$arr = range('A', 'Z');
		return $arr[$index].$index;
	}
}
