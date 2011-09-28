#!/bin/sh
#
# This script creates a mirror of core32 tree from repository.
# You can build your own snapshot from these files by editing and running makeiso.sh script.
#

rsync -avrh --delete --progress rsync://agilialinux.ru/core32 .
