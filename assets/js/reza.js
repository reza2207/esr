
  function cektgl(tgl){
    if(tgl == '0000-00-00')
      return '';
    else
      return tgl;
  }
  function formatNumber(num){
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,'$1.');
  }

  function cek_data(data){
    if(data == '0000-00-00' || data == '')
      return 'none';
    else
      return 'block';
  }
function strip(value){
    if(value == '' || value == null){
      return '-';
    }else{
      if(value.search("_") > 0){
        return value.replace("_", " ");
      }else{
        return value;
      }
      
    }
}

function tanggal(value){
  if(value == '0000-00-00' || value == null){
    return '';
  }else{
    let d = new Date(value); 
    let bulan = (d.getMonth()+1).toString().length == '1' ? '0'+(d.getMonth()+1).toString() : (d.getMonth()+1).toString();
    let tanggal = d.getDate().toString().length == '1' ? '0'+d.getDate().toString() : d.getDate().toString();
    //return tanggal+' '+get_month(bulan)+' '+d.getFullYear();
    //return tanggal+'-'+bulan+'-'+d.getFullYear();
    return tanggal+'-'+bulan+'-'+d.getFullYear();
  }  
}

function tanggal_indo(value){
  if(value == '0000-00-00' || value == null){
    return '-';
  }else{
    let d = new Date(value); 
    let bulan = (d.getMonth()+1).toString().length == '1' ? '0'+(d.getMonth()+1).toString() : (d.getMonth()+1).toString();
    let tanggal = d.getDate().toString().length == '1' ? '0'+d.getDate().toString() : d.getDate().toString();
    return tanggal+' '+get_month(bulan)+' '+d.getFullYear();
    //return tanggal+'-'+get_month(bulan)+'-'+d.getFullYear();
  }  
}
function get_month(month){
  switch (month) {
    case '01':
        month = "Jan";
        break;
    case '02':
        month = "Feb";
        break;
    case '03':
        month = "Mar";
        break;
    case '04':
        month = "Apr";
        break;
    case '05':
        month = "Mei";
        break;
    case '06':
        month = "Jun";
        break;
    case '07':
        month = "Jul";
        break;
    case '08':
        month = "Aug";
        break;
    case '09':
        month = "Sep";
        break;
    case '10':
        month = "Oct";
        break;
    case '11':
        month = "Nov";
        break;
    case '12':
        month = "Dec";
  }
  return month; 
}

function tanggal_biasa(tgl)
{
  if(tgl != ''){
    let tanggal = tgl.split(' ');
    let month = tanggal[1];
    switch (month) {
      case 'Januari':
          month = "01";
          break;
      case 'Februari':
          month = "02";
          break;
      case 'Maret':
          month = "03";
          break;
      case 'April':
          month = "04";
          break;
      case 'Mei':
          month = "05";
          break;
      case 'Juni':
          month = "06";
          break;
      case 'Juli':
          month = "07";
          break;
      case 'Agustus':
          month = "08";
          break;
      case 'September':
          month = "09";
          break;
      case 'Oktober':
          month = "10";
          break;
      case 'November':
          month = "11";
          break;
      case 'Desember':
          month = "12";
    }
    return tanggal[0]+'-'+month+'-'+tanggal[2];
  }else{
    return '';
  }
}
function tanggal_r(value){
  if(value == '-' || value ==''){
    return '';
  }else{
    let tgl = value.split('-');
    return tgl[2]+'-'+tgl[1]+'-'+tgl[0];

  }

}

function cek_similar(words, find){
  if(words !== null){
    if (words.indexOf(find) > -1) {
      return true;
    } else {
      return false;
    }
  }else{
    return false;
  }
}
