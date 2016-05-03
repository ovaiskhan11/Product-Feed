# Prototype of product feed

Example of how to handle very large XML-feeds without putting too much pressure on either the CPU or the memory. Because of that feeds can no longer be put into memory, but have to be processed in an alternative way.

Consists of two parts.

* Part 1: the interface

Small interface that will allow the user to submit a URL of a product feed. On submit, the URL should be processed (more on the processing function in part 2 of this assessment), and the results of that processing should be shown to the user.

* Part 2: processing the feed URL
The feed processing function should be able to handle very large feeds of a fixed format.

The feed is a few hundred megabytes large and contains thousands of products. 
fetch the given URL.

# Installation

* Download zip folder from github
* Extract the zip file in your local host or server
* Make folder named tt_assignment. you can change as per your need.
* Run Server using this command in CMD: D:\xampp\htdocs\tt_assignment>php bin/console server:run
* In CMD, it gives you the server url: http://127.0.0.1:8000
* Now open browser and hit the url: http://127.0.0.1:8000/product
* Enter url http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2&additionalType=2&limit=20 and submit
* Product feed will be display below search box 

# Tools
* Symfony3
* Bootstrap