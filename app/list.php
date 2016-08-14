<?php 
function listDirTree( $dirName = null ) 
{ 
if( empty( $dirName ) ) 
exit( "IBFileSystem: directory is empty." ); 
if( is_dir( $dirName ) ) 
{ 
if( $dh = opendir( $dirName ) ) 
{ 
$tree = array(); 
while( ( $file = readdir( $dh ) ) !== false ) 
{ 
if( $file != "." && $file != ".." ) 
{ 
$filePath = $dirName . "/" . $file; 
if( is_dir( $filePath ) ) { 
$tree[$file] = listDirTree( $filePath ); 
} 
else { 
$tree[] = $file; 
} 
} 
} 
closedir( $dh ); 
} 
else 
{ 
exit( "IBFileSystem: can not open directory $dirName."); 
} 
return $tree; 
} 
else 
{ 
exit( "IBFileSystem: $dirName is not a directory."); 
} 
} 
$files = listDirTree("."); ; 
$size = count(files); 
echo '<h2>File List:</h2>';
echo '<ol>'; 
for( $i=0; $files[$i] != NULL; $i++ ) { 
echo '<li><a href="'.($files[$i]).'" target="_blank">'.$files[$i].'</a></li>'; 
} 
echo '</ol>'; 
?> 