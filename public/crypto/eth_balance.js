var wallet_ip    = process.argv[2];
var wallet_port  = process.argv[3];
var from_address = process.argv[4];
var balance;

var Web3         = require('web3');
var web3         = new Web3("http://"+wallet_ip+":"+wallet_port);
 web3.eth.getBalance(from_address,function(err, balance) 
 {
 	console.log(balance);
 });

