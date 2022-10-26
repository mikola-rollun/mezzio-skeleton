#!/bin/bash

function get_config_value() {
  if [ -z "$1" ]; then
    echo "Error: config parameter name is empty in get_config_value()"
    return 1
  fi

  echo $(grep -oE "^$1=.*" .env | sed -E 's/^[^=]+=//g')
}

# (config_name, secret_name, dont_skip_empty_config_values)
function share_secret_from_config() {
  if [ -z "$1" ]; then
    echo "Error: copy_secret_from_config() parameter 1 (config parameter name) is empty"
    return 1
  fi

  if [ -z "$2" ]; then
    echo "Error: copy_secret_from_config() parameter 2 (secret name) is empty"
    return 1
  fi

  secrets_dir="./.container/secrets"
  mkdir -p $secrets_dir # if called the first time

  # Return if value empty
  source_path=$(get_config_value "$1")
  if [ -z "$source_path" ]; then
    if [ ! -z "$3" ]; then
      echo "Error: copy_secret_from_config() secret value for \"$1\" is empty"
      return 1
    # Just skip the value
    else
      return 0
    fi
  fi
  source_path=$(realpath_shim "$source_path" )
  target="./.container/secrets/$2"

  if [ ! -f "$source_path" ] && [ ! -d "$source_path" ] && [ ! -L "$source_path" ]; then
    cat "~/.ssh/id_rsa"
    echo "Error: copy_secret_from_config() file \"$source_path\" does not exist"
    return 1
  fi

  cp $source_path $target
}

function unshare_secrets() {
  secrets_dir="./.container/secrets"

  # Remove files from secrets directory
  if [ "$(ls $secrets_dir | wc -l)" -gt 0 ]; then
    rm $secrets_dir/*
  fi

  if [ -d "$secrets_dir" ]; then
    rmdir $secrets_dir
  fi
}

function realpath_shim() {
  # Check does not exists
  if [ ! -z "$2" ] \
  && [ ! -d "$1" ] && [ ! -f "$1" ]; then
    echo realpath: "$1": No such file or directory
    return 1
  fi

  if ! command -v realpath &> /dev/null; then
    eval path="$1"
    echo "$path"
  else
    eval path="$1"
    realpath "$path"
  fi
}

function get_os_type() {
  # https://stackoverflow.com/questions/394230/how-to-detect-the-os-from-a-bash-script/18434831
  case $(uname | tr '[:upper:]' '[:lower:]') in
    linux*)
      echo linux
      ;;
    darwin*)
      echo osx
      ;;
    msys*)
      echo windows
      ;;
    *)
      echo unknown
      ;;
  esac
}
