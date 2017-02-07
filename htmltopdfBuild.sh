#!/bin/bash

PATH_SCRIPT=$(dirname "$0")
PLATEFORME="dev-"
DOMAINE="example.com"
HTPASSWD="false"
VHOST_PATH="vhost/htmltopdf.conf"

function usage()
{
    echo "./htmltopdfBuild.sh"
    echo "  -h --help"
    echo "  --domaine=${DOMAINE}"
    echo "  --plateforme=${PLATEFORME}"
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
sed -i -e "s/%plateforme%/${PLATEFORME}/g" $PATH_SCRIPT/vhost/htmltopdf.conf
sed -i -e "s/%domaine%/${DOMAINE}/g" $PATH_SCRIPT/vhost/htmltopdf.conf
echo "Fichier vhost htmltopdf généré: ${VHOST_PATH}"