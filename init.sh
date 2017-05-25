#! /bin/bash

if [ "$1" == "" ]; then
    echo "请输入包名"
fi

base=$(dirname $(pwd))

path=${base}"/"$1 

if [ ! -d "/${path}" ]; then
  mkdir $path
  cp -r $(pwd)/ $path
  echo '创建文件夹完成';
else
  echo '路径已存在！！！'
fi