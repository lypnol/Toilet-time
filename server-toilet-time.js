var http = require('http');
var dispatcher = require('httpdispatcher');
var url = require( "url" );
var queryString = require( "querystring" );
var mysql = require('mysql');

const PORT=2345; 

function URLToArray(url) {
    var request = {};
    var pairs = url.substring(url.indexOf('?') + 1).split('&');
    for (var i = 0; i < pairs.length; i++) {
        if(!pairs[i])
            continue;
        var pair = pairs[i].split('=');
        request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
     }
     return request;
}

var mysql_connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'toilet',
  password : 'toilet',
  database : 'hackthon'
}); 

mysql_connection.connect();

function handleRequest(request, response){
    try {
        //Disptach
        dispatcher.dispatch(request, response);
    } catch(err) {
        console.log(err);
    }
}

//A sample GET request    
dispatcher.onGet("/", function(req, res) {
    console.log("get:"+req.url+"\n");
    var params = URLToArray(req.url);
    var date = new Date();
    var timestamp = date.getTime();
    res.writeHead(200, {'Content-Type': 'text/plain'});
    var sqlQuery = 'INSERT INTO data (`key`,`value`,`date`) VALUES(\''+params.key+'\','+params.value+','+timestamp+')';
    console.log(sqlQuery);
    mysql_connection.query(sqlQuery, function(err){
        if (!err)
             res.end('Got it');
        else
             res.end('Error occured');
    });
});    


var server = http.createServer(handleRequest);

server.listen(PORT, function(){
    console.log("Server listening on: http://localhost:%s", PORT);
});

