#!/bin/bash
#@****************************************************************************
#@ Author : Mathieu GOULIN (matgou@kapable.info)
#@ Organization : Kapable.info
#@ Licence : GNU/GPL
#@ 
#@ Description : 
#@               
#@ Prerequisites :
#@ Arguments : 
#@
#@****************************************************************************
#@ History :
#@  - Mathieu GOULIN - 2014/06/20 : Initialisation du script
#@****************************************************************************
 
# Static configuration
script=`basename "$0" | cut -f1 -d"."`
log_file=/var/log/$script.log
server=pfhd1.kapable.info
zone=dyn.ecloud.fr
key=`dirname $0`/Kvcwd2.kapable.info.+157+48229.private

 
# Usage function
function usage () {
    echo "$0 <host> <ip>"
}
# Help function
function help () {
    usage
    echo
    grep -e "^#@" $script.sh | sed "s/^#@//"
}
 
# Log function
write_log () {
    log_state=$1
    shift;
    log_txt=$*
    log_date=`date +'%Y/%m/%d %H:%M:%S'`
    case ${log_state} in
        BEG)    chrtra="[START]"      ;;
        CFG)    chrtra="[CONF ERR]"   ;;
        ERR)    chrtra="[ERROR]"      ;;
        END)    chrtra="[END]"        ;;
        INF)    chrtra="[INFO]"       ;;
        *)      chrtra="[ - ]"        ;;
    esac
    echo "$log_date $chrtra : ${log_txt}" | tee -a ${log_file} 2>&1
}
 
if [ $# -lt 2 ]
then
    usage
fi 
#**************************************************************************
#@ Steps : get public ip
#**************************************************************************
fdqn=$1
PUBLIC_IP=$2

#**************************************************************************
#@ Steps : Replace dns entry with rndc 
#**************************************************************************
ficupdate=`mktemp`

cat > $ficupdate << EOF
server $server
zone $zone
update delete $fdqn A
update add $fdqn 300 A $PUBLIC_IP
show
send
EOF

cat $ficupdate
nsupdate -k $key -v $ficupdate
exit $?
