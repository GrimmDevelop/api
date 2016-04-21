#!/usr/bin/env bash

# Install Java 8
hash java 2>/dev/null || { sudo add-apt-repository ppa:webupd8team/java; sudo apt-get update; sudo apt-get install oracle-java8-installer; }

java -version

# Install Elasticsearch
wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
echo "deb http://packages.elastic.co/elasticsearch/2.x/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-2.x.list

sudo apt-get update
sudo apt-get install elasticsearch

sudo update-rc.d elasticsearch defaults 95 10
