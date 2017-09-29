msg.headers = {  
"Content-Type": "application/json",  
"Authorization": "Bearer 624370ac94ae4d28ae9b28d0c94fa2bc"  
}  

var timestamp = String(msg.payload);  
var lasttwo = timestamp.substr(timestamp.length - 2);  

msg.payload = {"data": 
{"current":lasttwo},  
"sdid": "81a2a4a3e2584101bf843d8e0037cd88",  
"type": "message"  
}  
return msg; 



msg.headers = {  
"Content-Type": "application/json",  
"Authorization": "Bearer f2c9086b338248cfabfa7dc649a3e479"  
}  

var timestamp = String(msg.payload);  
var lasttwo = timestamp.substr(timestamp.length - 2);  

msg.payload = {"data": 
{"current":lasttwo},  
"sdid": "8a0a6ceeb91a4baf926990ad6226b582",  
"type": "message"  
}  
return msg; 
