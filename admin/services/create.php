<?php
$title = 'Create service';
$icon  = 'cubes';
include __DIR__.'/../template/header.php';
require_once __DIR__.'/../../classes/Upload.php';




$errors = [];
$name = '';
$price = '';
$description = '';
$sunday = '';
$monday = '';
 $tuesday = '';
 $wednesday = '';
 $thuraday = '';
 $friday = '';
 $saturday = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    $count = count($_POST['time']);

    $name = mysqli_real_escape_string($mysqli , $_POST['name']);
    $price = mysqli_real_escape_string($mysqli , $_POST['price']);
    $description = mysqli_real_escape_string($mysqli , $_POST['description']);

    if(empty($name)){array_push($errors,"Name is require");}
    if(empty($price)){array_push($errors,"Price is require");}
    if(empty($description)){array_push($errors,"Description is require");}
    if(empty($_FILES['image']['name'])){array_push($errors, "Image is required");}

    isset($_POST['sunday']) ? $sunday = "yes" : $sunday = "no";
    isset($_POST['monday']) ? $monday = "yes" : $monday = "no";
    isset($_POST['tuesday']) ? $tuesday = "yes" : $tuesday = "no";
    isset($_POST['wednesday']) ? $wednesday = "yes" : $wednesday = "no";
    isset($_POST['thursday']) ? $thursday = "yes" : $thursday = "no";
    isset($_POST['friday']) ? $friday = "yes" : $friday = "no";
    isset($_POST['saturday']) ? $saturday = "yes" : $saturday = "no";


    if(!count($errors)){
        $date = date('Ym');
        $upload = new Upload('uploads/services/'.$date);
        $upload->file = $_FILES['image'];
        $errors = $upload->upload();
    }

    if(!count($errors)){


        $query = "insert into services (name, price, description) values('$name','$price','$description')";
        $mysqli->query($query);

        if ($mysqli->error) {
            array_push($errors, $mysqli->error);

        }else {

          $last_id = $mysqli->insert_id;
          $query = "insert into images_services (service_id, image) values('  $last_id','$upload->filePath')";
          $mysqli->query($query);

            if ($mysqli->error){
              array_push($errors, $mysqli->error);
            }else {
              $query = "insert into werkdays_services (service_id, sunday, monday, tuesday, wednesday, thursday, friday, saturday ) values
              ('$last_id','$sunday' , '$monday' , ' $tuesday' , '$wednesday' , '$thursday' , '$friday' , '$saturday')";
              $mysqli->query($query);

              if ($mysqli->error) {
                  array_push($errors, $mysqli->error);
              }else {
                for ($i=0; $i <$count ; $i++) {
                  $indexOfTimeInput = $_POST['time'][$i];
                  $query = "insert into times_services (service_id , time_service)
                  values ('$last_id' , '  $indexOfTimeInput')";
                  $mysqli->query($query);
                }
              }
            }
            echo "<script>location.href = 'index.php'</script>";

        }


    }
}
?>
<div class="card">
  <div class="content">
    <?php include __DIR__.'/../template/errors.php' ?>
    <form action="" method="post" enctype="multipart/form-data">


        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control"  id="name" value="<?php echo $name ?>">
        </div>

        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" name="price" class="form-control"  id="price" value="<?php echo $price ?>">
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea name="description" id="description" rows="10" cols="30" class="form-control"><?php echo $description ?></textarea>
        </div>
        <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" name="image" >
      </div>

        <div class="form-group">
          <label for="">Werkdays </label>
          <div class="custom-control custom-checkbox custom-control-inline">

            <input type="checkbox" class="custom-control-input" name="sunday" id="sunday">
            <label class="custom-control-label" for="sunday">Sunday</label>

            <input type="checkbox" class="custom-control-input" name="monday" id="monday">
            <label class="custom-control-label" for="monday">Monday</label>

            <input type="checkbox" class="custom-control-input" name="tuesday" id="tuesday">
            <label class="custom-control-label" for="tuesday">Tuesday</label>

            <input type="checkbox" class="custom-control-input" name="wednesday" id="wednesday">
            <label class="custom-control-label" for="wednesday">Wednesday</label>

            <input type="checkbox" class="custom-control-input" name="thursday" id="thursday">
            <label class="custom-control-label" for="thursday">Thuraday</label>

            <input type="checkbox" class="custom-control-input" name="friday" id="friday">
            <label class="custom-control-label" for="friday">Friday</label>

            <input type="checkbox" class="custom-control-input" name="saturday" id="saturday">
            <label class="custom-control-label" for="saturday">Saturday</label>

        </div>
      </div>

      <div class="form-group" id="1">

        <button type="button" name="button" id="b">+</button>
        <label for="">add Time</label>
      <hr>
        <div class="">
          <button type="button" name="button" id="s">-</button>
          <input type="time" name="time[]" value="">
          <hr>
        </div>

      </div>
      <script>

      document.addEventListener('click' , (e)=> {
        // e.preventDefault();
        let {target} = e;
        if (target && target.id == 's') {
            target.parentElement.remove();
        }else if (target && target.id == 'b') {
          let div = document.createElement('div');
          div.innerHTML = ` <button type="button" name="button" id="s">-</button>
                            <input type="time" name="time[]" value="">
                             <hr>
                              `;
          document.getElementById('1').append(div);

        }

      })

      </script>
      <hr>
      <div class="form-group">
          <button class="btn btn-success">Create!</button>
      </div>
    </form>
  </div>
</div>
<?php $mysqli->close(); ?>
<?php
include __DIR__.'/../template/footer.php';

 ?>
 <!-- <div class="form-group">
   <label for="">Beginning work</label>
   <div class="">
     <label for="image">Hours:</label>
     <select class="" name="">
       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
       <option value="6">6</option>
       <option value="7">7</option>
       <option value="8">8</option>
       <option value="9">9</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>

     </select>
       <label for="image">minutes:</label>
     <select class="" name="">
       <option value="1">00</option>
       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
       <option value="6">6</option>
       <option value="7">7</option>
       <option value="8">8</option>
       <option value="9">9</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       <option value="13">13</option>
       <option value="14">14</option>
       <option value="15">15</option>
       <option value="16">16</option>
       <option value="17">17</option>
       <option value="18">18</option>
       <option value="19">19</option>
       <option value="20">20</option>
       <option value="21">21</option>
       <option value="22">22</option>
       <option value="23">23</option>
       <option value="24">24</option>
       <option value="25">25</option>
       <option value="26">26</option>
       <option value="27">27</option>
       <option value="28">28</option>
       <option value="29">29</option>
       <option value="30">30</option>
       <option value="31">31</option>
       <option value="32">32</option>
       <option value="33">33</option>
       <option value="34">34</option>
       <option value="35">35</option>
       <option value="36">36</option>
       <option value="37">37</option>
       <option value="38">38</option>
       <option value="39">39</option>
       <option value="40">40</option>
       <option value="41">41</option>
       <option value="42">42</option>
       <option value="43">43</option>
       <option value="44">44</option>
       <option value="45">45</option>
       <option value="46">46</option>
       <option value="47">47</option>
       <option value="48">48</option>
       <option value="49">49</option>
       <option value="50">50</option>
       <option value="51">51</option>
       <option value="52">52</option>
       <option value="53">53</option>
       <option value="54">54</option>
       <option value="55">55</option>
       <option value="56">56</option>
       <option value="57">57</option>
       <option value="58">58</option>
       <option value="59">59</option>
       <option value="60">60</option>

     </select>
       <label for="image">Hours:</label>
     <select class="" name="">
       <option value="1">pm</option>
       <option value="2">am</option>

     </select>
   </div>
   <div class="">
     <input type="time" name="time" value="">
   </div>

 </div>

 <div class="form-group">
   <label for="">End of work</label>
   <div class="">
     <label for="image">Hours:</label>
     <select class="" name="">
       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
       <option value="6">6</option>
       <option value="7">7</option>
       <option value="8">8</option>
       <option value="9">9</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>

     </select>
       <label for="image">minutes:</label>
     <select class="" name="">
       <option value="1">00</option>

       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
       <option value="6">6</option>
       <option value="7">7</option>
       <option value="8">8</option>
       <option value="9">9</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       <option value="13">13</option>
       <option value="14">14</option>
       <option value="15">15</option>
       <option value="16">16</option>
       <option value="17">17</option>
       <option value="18">18</option>
       <option value="19">19</option>
       <option value="20">20</option>
       <option value="21">21</option>
       <option value="22">22</option>
       <option value="23">23</option>
       <option value="24">24</option>
       <option value="25">25</option>
       <option value="26">26</option>
       <option value="27">27</option>
       <option value="28">28</option>
       <option value="29">29</option>
       <option value="30">30</option>
       <option value="31">31</option>
       <option value="32">32</option>
       <option value="33">33</option>
       <option value="34">34</option>
       <option value="35">35</option>
       <option value="36">36</option>
       <option value="37">37</option>
       <option value="38">38</option>
       <option value="39">39</option>
       <option value="40">40</option>
       <option value="41">41</option>
       <option value="42">42</option>
       <option value="43">43</option>
       <option value="44">44</option>
       <option value="45">45</option>
       <option value="46">46</option>
       <option value="47">47</option>
       <option value="48">48</option>
       <option value="49">49</option>
       <option value="50">50</option>
       <option value="51">51</option>
       <option value="52">52</option>
       <option value="53">53</option>
       <option value="54">54</option>
       <option value="55">55</option>
       <option value="56">56</option>
       <option value="57">57</option>
       <option value="58">58</option>
       <option value="59">59</option>
       <option value="60">60</option>

     </select>
       <label for="image">Hours:</label>
     <select class="" name="">
       <option value="1">pm</option>
       <option value="2">am</option>

     </select>
   </div>
   <div class="">
     <input type="time" name="time" value="">
   </div>

 </div>
 <div class="form-group">
   <label for="">Time per customer</label>
   <div class="">
     <label for="image">Hours:</label>
     <select class="" name="">
       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
       <option value="6">6</option>
       <option value="7">7</option>
       <option value="8">8</option>
       <option value="9">9</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>

     </select>
       <label for="image">minutes:</label>
     <select class="" name="">
       <option value="1">00</option>

       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
       <option value="6">6</option>
       <option value="7">7</option>
       <option value="8">8</option>
       <option value="9">9</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       <option value="13">13</option>
       <option value="14">14</option>
       <option value="15">15</option>
       <option value="16">16</option>
       <option value="17">17</option>
       <option value="18">18</option>
       <option value="19">19</option>
       <option value="20">20</option>
       <option value="21">21</option>
       <option value="22">22</option>
       <option value="23">23</option>
       <option value="24">24</option>
       <option value="25">25</option>
       <option value="26">26</option>
       <option value="27">27</option>
       <option value="28">28</option>
       <option value="29">29</option>
       <option value="30">30</option>
       <option value="31">31</option>
       <option value="32">32</option>
       <option value="33">33</option>
       <option value="34">34</option>
       <option value="35">35</option>
       <option value="36">36</option>
       <option value="37">37</option>
       <option value="38">38</option>
       <option value="39">39</option>
       <option value="40">40</option>
       <option value="41">41</option>
       <option value="42">42</option>
       <option value="43">43</option>
       <option value="44">44</option>
       <option value="45">45</option>
       <option value="46">46</option>
       <option value="47">47</option>
       <option value="48">48</option>
       <option value="49">49</option>
       <option value="50">50</option>
       <option value="51">51</option>
       <option value="52">52</option>
       <option value="53">53</option>
       <option value="54">54</option>
       <option value="55">55</option>
       <option value="56">56</option>
       <option value="57">57</option>
       <option value="58">58</option>
       <option value="59">59</option>
       <option value="60">60</option>

     </select>

   </div>
   <div class="">
     <input type="time" name="time" value="">
   </div>

 </div> -->
