<?php
$fp = fopen("kadai1-6.txt", "r");
while(!feof($fp)){ //feof�֐��̓t�@�C���̏I�[�ɒB���Ă��Ȃ��ԃ��[�v
  print fgets($fp)."<br />";
}
