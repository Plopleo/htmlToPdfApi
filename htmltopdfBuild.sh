#!/bin/bash

PATH_SCRIPT=$(dirname "$0")
PLATEFORME="dev-"
DOMAINE="example.com"
VHOST_PATH="vhost/htmltopdf.conf"
PHPCONF_PATH="vhost/htmltopdf.ini"
MEMORY_LIMIT=1024M

function usage()
{
    echo "./htmltopdfBuild.sh"
    echo "  -h --help"
    echo "  --domaine=${DOMAINE}"
    echo "  --plateforme=${PLATEFORME}"
    echo "  --memory-limit=${MEMORY_LIMIT}"
    echo ""
}

while [ "$1" != "" ]; do
    PARAM=`echo $1 | awk -F= '{print $1}'`
    VALUE=`echo $1 | awk -F= '{print $2}'`
    case $PARAM in
        -h | --help)
            usage
            exit
            ;;
        --domaine)
            DOMAINE=$VALUE
            ;;
        --plateforme)
            PLATEFORME=$VALUE
            ;;
        --memory-limit)
            MEMORY_LIMIT=$VALUE
            ;;
        *)
            echo "ERREUR: parametre inconnu \"$PARAM\""
            usage
            exit 1
            ;;
    esac
    shift
done

## Gestion de la conf apache
echo "Génération de la configuration Apache avec en plateforme $PLATEFORME et en domaine $DOMAINE dans vhost "
cp $PATH_SCRIPT/${VHOST_PATH}.tpl $PATH_SCRIPT/${VHOST_PATH}
sed -i'.bk' -e "s/%plateforme%/${PLATEFORME}/g" $PATH_SCRIPT/vhost/htmltopdf.conf
sed -i'.bk' -e "s/%domaine%/${DOMAINE}/g" $PATH_SCRIPT/vhost/htmltopdf.conf
echo "Fichier vhost htmltopdf généré: ${VHOST_PATH}"

## Gestion de la conf php
echo "Memory limit set à $MEMORY_LIMIT"
cp $PATH_SCRIPT/${PHPCONF_PATH}.tpl $PATH_SCRIPT/${PHPCONF_PATH}
sed -i'.bk' -e "s/%memory_limit%/${MEMORY_LIMIT}/g" $PATH_SCRIPT/${PHPCONF_PATH}
echo "Fichier conf php généré: ${PHPCONF_PATH}"
