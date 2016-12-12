#!/usr/bin/php 
<?php 

// Set these manually since Subversion doesn't set ENV
$PHP = '/usr/bin/php'; 
$AWK = '/usr/bin/awk'; 
$GREP = '/usr/bin/egrep'; 
$SED = '/bin/sed'; 
  
// Find all files...
$REMOTE_BRANCH=str_replace(array(PHP_EOL, "\r"), ' ', $REMOTE_BRANCH);
$FILES=`find . -type f`; 
// ...as an array
$FILES = split(PHP_EOL,$FILES);  
$errors = Array();

// Perform specific actions based on the file extension 
foreach($FILES as $FILE){ 
  error_log($FILE);
 switch(pathinfo($FILE,PATHINFO_EXTENSION)){ 
 case 'php': 
    // Get just the error/no error message from php -l
    $cmd="$PHP -l '$FILE' | head -2 | tail -1"; 
    $msg=trim(rtrim(`$cmd`));
    if(preg_match('/No syntax errors detected/',$msg) != 1){ 
       $msg = preg_replace('/in - /','',$msg); 
       $errors[] = "In $FILE: $msg"; 
    }
   break; 
  case 'js':
    // You could do something else for JavaScript -- like JSLint, if you're brave
    break;
 } 
} 
 
// Print all the errors in a nice list
if(count($errors) > 0){ 
 $warning =" 
************************************************************************* 
* Please correct the following errors! * 
************************************************************************* 
"; 
 error_log($warning); 
 for($i = 1;$i <= count($errors);$i++){ 
 error_log("$i. " . $errors[($i - 1)]); 
 } 
 
 exit(-1); 
} 

error_log("Succeeded.");
 
exit(0);