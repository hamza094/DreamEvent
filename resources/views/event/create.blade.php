@include('header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>


<div class="container">
<h1 class="mt-4">Strat Your Own Event</h1>
    <h5>Organize your whole event detail here</h5>
   <div class="row">
<form action="/event-create" method="post" class="col s12" enctype="multipart/form-data">
{{csrf_field()}}
<div class="row">
        <div class="input-field col s12">
          <input id="name" type="Text" name="name" required>
          <label for="name"><b>Name</b></label>
        </div>
      </div>
    <div class="row">
        <div class="input-field col s6">
          <input placeholder="12 Dec 2012" id="startdate" name="strtdt" class="strtdate" type="text" required>
            <label for="startdate"><b>Start Date</b></label>
        </div>
        <div class="input-field col s6">
          <input id="starttime" type="text" class="strttime" name="strttm" placeholder="10:41 PM" required>
            <label for="starttime"><b>Start Time</b></label>
        </div>
      </div>
     <div class="row">
        <div class="input-field col s6">
          <input placeholder="13 Dec 2012" id="enddate" name="enddt" class="enddate" type="text">
            <label for="startdate"><b>End Date</b></label>
        </div>
        <div class="input-field col s6">
          <input id="endtime" type="text" class="endtime" name="endtm" placeholder="11:41 PM" required>
            <label for="endtime"class="black=text"><b>End Time</b></label>
        </div>
      </div>
     <div class="row">
        <div class="input-field col s6">
          <input id="location" type="text" name="location" placeholder="Enter a location" required>
            <label for="location"><b>Location</b></label>
        </div>
         <div class="input-field col s6">
          <input id="venue" type="text" name="venue" placeholder="Enter a venue" required>
             <label for="Venue"><b>Venue Place</b></label>
        </div>
      </div>
              <div class="row">
           <div class="input-field col s12">
    <select name="topic_id" id="topic">
      <option value="" disabled selected>Choose your topic</option>
      @foreach($topics as $topic)
      <option value="{{$topic->id}}">{{$topic->name}}</option>
      @endforeach
    </select>
    <label><b>Topic</b></label>
  </div>
      </div>
         <div class="row desc">
        <div class="input-field col s12">
                    <label for="desc"><b>Event Description</b></label>
                    <br><br>
        <textarea  id="desc" class="materialize-textarea" name="desc"></textarea>
        </div>
      </div>
    <div class="row">
        <div class="input-field col s6">
          <input id="price" type="Text" name="price" required>
            <label for="price"><b>Price</b></label>
        </div>
         <div class="input-field col s6">
          <input id="qty" type="number" name="qty" required>
            <label for="qty"><b>Quantity</b></label>
        </div>
      </div>
        <div class="row">
              <div class="file-field input-field col s12">
      <div class="btn form-btn">
        <span>Image</span>
        <input type="file" accept="image/*" name="image" required>
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text" placeholder="Upload your event image">
      </div>
    </div>
        </div>
               <recaptcha ref="recaptcha" sitekey="6LeTpcUUAAAAAEOej3UsFeb-nRJIVZHKVFC1BVwS"></recaptcha>

  <button class="waves-effect waves-light form-btn  btn mb-5 mt-2 float-right" type="submit">Create An Evenet</button>
</form>
</div>
</div>
  @if($errors->count()>0)
    <ul class="list-group-item">
        @foreach($errors->all() as $error)
        <li class="list-group-item text-danger">
            {{$error}}
        </li>
        
        @endforeach
        @endif
    </ul>
@include('footer')