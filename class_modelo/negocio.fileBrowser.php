<?php
class FileBrowser extends Persistencia {
  function retornaTipo($filename){
      $arr = explode(".", $filename);
      $retorno = "txt";
      if(count($arr) > 1){
          $ext = strtolower(substr($arr[1],0,3));
          $retorno = $ext;
      }
      return $retorno;
  }
   
   function dirToArray($dir) {
  
   $result = array();

   $cdir = scandir($dir,SCANDIR_SORT_DESCENDING);
   foreach ($cdir as $key => $value)
   {
      if (!in_array($value,array(".","..")))
      {
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
         {
            $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
         }
         else
         {
            array_push($result,$value);
         }
      }
   }
  
   return $result;
} 
}
?>