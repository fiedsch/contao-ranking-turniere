#!/bin/bash

SITE=/Users/andreas/Sites/edart-bayern.de

EXTENSION=ranking

if [ ! -d $SITE/system/modules/$EXTENSION ]
then
    sudo mkdir $SITE/system/modules/$EXTENSION
fi
sudo cp -r ./ $SITE/system/modules/$EXTENSION

sudo rm -f $SITE/system/modules/$EXTENSION/install.sh

sudo chown -R _www $SITE/system/modules/$EXTENSION
sudo chmod -R ug+r $SITE/system/modules/$EXTENSION
echo "done"