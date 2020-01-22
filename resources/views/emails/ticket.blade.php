<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dream Event Ticket Receipt</title>
         <style>
      .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 15cm;  
  height: 29.7cm; 
margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-size: 14px; 
}

header {
  padding: 10px 0;
  margin-bottom:70px;
  /*border-bottom: 1px solid #AAAAAA;*/
}

#logo {
  text-align: center;
  margin-top: 8px;
  color:#5CDB95;    
}

#company {
  text-align: center;
}


#details {
  margin-bottom: 30px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.3em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  text-align: center;
    padding-top: 110px;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 20px;
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: right;
}

table td h3{
  color: #2D395D;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: #2D395D;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #2D395D;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #2D395D;
  font-size: 1.4em;
  border-top: 1px solid #2D395D; 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}

      
      </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
      <h1>Dream Event</h1>
      </div>
      <div id="company">
        <h2 class="name">Dream Event</h2>
        <div>455 Foggy Heights, AZ 54700, LHR</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:dreamevent@gmail.com">dreamevent@gmail.com</a></div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">INVOICE TO:</div>
          <h2 class="name">{{$name}}</h2>
          <div class="email"><a href="mailto:{{$user}}">{{$user}}</a></div>
        </div>
        <div id="invoice">
           <h1>Recipt No# {{$recipt}}</h1>
          <div class="date">Date of Invoice: {{$date}}</div>
          <div class="date">Due Date: {{$date}}</div>
        </div>
      </div>
      <br><br>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">PER TICKET PRICE</th>
            <th class="qty">QUANTITY</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="no">01</td>
              <td class="desc"><a href="http://localhost:8000/events/{{$eventSlug}}"><h3>{{$eventName}}</h3></a></td>
            <td class="unit">${{$price}}</td>
            <td class="qty">{{$qty}}</td>
            <td class="total">${{$total}}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>${{$total}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">TAX 0%</td>
            <td>${{$total}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td>${{$total}}</td>
          </tr>
        </tfoot>
      </table>
      <div id="thanks">Thank you!</div>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">Ticket Purchased from crad brand {{$brand}} with last four {{$last4}}</div>
      </div>
    </main>
    <footer>
      If you haven't purchased this item please contact us.
    </footer>
  </body>
</html>

      
    
