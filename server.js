var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);
 
io.on('connection', function(socket){
  
  let id = socket.id;
  socket.on('send_user', function(data){
    console.log(data);
  })
  socket.on('broadcast', function(data){
    io.emit('broadcast', data);
  })

  socket.on('register_masuk', function(){
    io.emit('reload-regist-msk');
  })
  console.log('a user connected on '+Date());
  socket.on('disconnect', function(){
    console.log('user disconnected on '+Date());
  });

  socket.on('reload-user', function(kata){
    io.emit('reload', kata);

    console.log(kata+' on '+Date());
  });

  socket.on('notification', function(str){
    io.emit('reload', str);
    console.log(str+' on '+Date());
  })
  socket.on('logout-user', function(kata){
    io.emit('reload', kata);
    console.log(kata+' on '+Date());
  })

  socket.on('update_task', function(){
    io.emit('cek_task');
  })

  socket.on('reload_table', function(){
    io.emit('reload_table');
  })
  socket.on('reminder', function(data){
    io.emit('reminder', data);
  })
});
 
http.listen(3000, function(){
  console.log('listening on *:3000');
});
 