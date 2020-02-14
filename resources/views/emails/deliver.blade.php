<html>
    <head>
        <style>
        body {
  background: #dd3f3e;
  font-family: 'Montserrat', sans-serif;
  margin: 0;
  padding: 0;
}

.ticket {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 700px;
  margin: 20px auto;
}
            
  .stub, .check {
    box-sizing: border-box;
  }

.qty{
    margin-top: 19px;            
}
.stub {
  background: #ef5658;
  height: 250px;
  width: 250px;
  color: white;
  padding: 20px;
  position: relative;
}
  .stub:before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    border-top: 20px solid #dd3f3e;
    border-left: 20px solid #ef5658;
    width: 0;
  }
  .stub:after {
    content: '';
    position: absolute;
    bottom: 0; right: 0;
    border-bottom: 20px solid #dd3f3e;
    border-left: 20px solid #ef5658;
    width: 0;
  }
  
  .top {
    display: flex;
    align-items: center;
    height: 40px;
    text-transform: uppercase;
    }
    .line {
      display: block;
      background: #fff;
      height: 40px;
      width: 3px;
      margin: 0 20px;
    }
    .num {
      font-size: 10px;
    }
    .num  span {
        color: #000;
      }
    }
  
  .number {
    position: absolute;
    left: 40px;
    font-size: 150px;
  }
  .invite {
    position: absolute;
    left: 150px;
    bottom: 30px;
    color: #000;
    width: 20%;
}
    .invite:before {
      content: '';
      background: #fff;
      display: block;
      width: 40px;
      height: 3px;
      margin-bottom: 5px;     
    }
  


.check {
  background: #fff;
  height: 250px;
  width: 450px;
  padding: 40px;
  position: relative;
}
  .check:before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    border-top: 20px solid #dd3f3e;
    border-right: 20px solid #fff;
    width: 0;
  }
  .check::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    border-bottom: 20px solid #dd3f3e;
    border-right: 20px solid #fff;
    width: 0;
  }
  
  .big {
    font-size: 30px;
    font-weight: 900;
    line-height: .8em;
  }
.head{
   font-size: 15px;
    font-weight: 900;
    line-height: .8em;      
    }
   .venue{
    font-size:13px;
    margin-top: 11px;   
    }
  .number {
    position: absolute;
    top: 50px;
    right: 50px;
    color: #ef5658;
    font-size: 40px;
  }
  .info {
    display: flex;
    justify-content: flex-start;
    
    font-size: 12px;
    margin-top: 20px;
    width: 100%;
}
    .info section {
      margin-right: 50px;
    }
      .info secttion:before{
        content: '';
        background: #ef5658;
        display: block;
        width: 40px;
        height: 3px;
        margin-bottom: 5px;
      }
      .title {
        font-size: 10px;
        text-transform: uppercase;
      }
    .barcode {
           position: absolute;
    left: 15px;
    bottom: 45px;
  height: 2em;
  width: 0;
  margin: 1.2em 0 0 .8em;
  box-shadow: 1px 0 0 1px black,
  5px 0 0 1px black,
  10px 0 0 1px black,
  11px 0 0 1px black,
  15px 0 0 1px black,
  18px 0 0 1px black,
  22px 0 0 1px black,
  23px 0 0 1px black,
  26px 0 0 1px black,
  30px 0 0 1px black,
  35px 0 0 1px black,
  37px 0 0 1px black,
  41px 0 0 1px black,
  44px 0 0 1px black,
  47px 0 0 1px black,
  51px 0 0 1px black,
  56px 0 0 1px black,
  59px 0 0 1px black,
  64px 0 0 1px black,
  68px 0 0 1px black,
  72px 0 0 1px black,
  74px 0 0 1px black,
  77px 0 0 1px black,
  81px 0 0 1px black;
}
.receipt{
position: absolute;
left: 30px;
bottom: 20px; 
color:black;    
}            
  


        </style>
    </head>
    <body>
     <div class="ticket">
  <div class="stub">
    <div class="top">
      <span class="admit">Ticket</span>
      <span class="line"></span>
      <span class="num">
        From
        <span>DreamEvent</span>
      </span>
    </div>
    <div class="qty">
        Name: <b>{{$ticket->user->name}}</b>
    </div>
    <br>
    <div>
        Ticket Qty: {{$ticket->qty}}
    </div>
    <div class="barcode"></div>
      <div class="receipt"><b>{{$ticket->receipt}}</b></div>
    <div class="invite">
      By
      {{$ticket->event->user->name}}
    </div>
  </div>
  <div class="check">
   <div class="head">
      You're Invited To Event:
    </div>
    <br>
    <div class="big">
      {{$ticket->event->name}}
    </div>
    <div class="info">
      <section>
        <div class="title">Date</div>
        <div>{{$ticket->event->eventstart}}</div>
      </section>
    <section>
        <div class="title">Time PKST</div>
        <div>{{$ticket->event->strttm}}</div>
    </section>
       <section>
        <div class="title">Location</div>
        <div>{{$ticket->event->location}}</div>
      </section>
    </div>
     <div class="venue">
         <b>Venue: </b> {{$ticket->event->venue}}
      </div>
      </div>
      
</div>
   
    </body>
</html>

