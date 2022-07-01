<?php 
include('log.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<?php include('../load.php');?>
  <section class="sec-nav">
  <nav>
        <a href="home.php" class="logo">Agro</a>
        <ul>
          <li><a href="home.php" class="active">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="add.php">Manage Products</a></li>
          <li><a href="order.php">Orders</a></li>
          <li><a href="process.php">Process Orders</a></li>
          <li><a href="userinfo.php">User Info</a></li>
          <li><a href="log.php?logID=<?php echo ($log); ?>" name="log" onclick="Log()" ><i class="fa fa-user"></i>
          <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>

      <section class="sec-text" data-aos="fade-left">
      <div class="text-container">
      <p>Buy</p>
      <p>Organic & fresh <span class="typing"></span></p>
      <p>From Agro Farm</p>
    </div>
    </section>

  <section class="sec-card" data-aos="slide-up">
        <div class="box-container">
      <div class="slider owl-carousel">

        <div class="card">
          <div class="content">
              <img src="../img/fruits.jpg">
            <div class="title">Fruits</div>
            <p>
            Fruits are an excellent source of essential vitamins and minerals, and they are high in fiber. 
            Fruits also provide a wide range of health-boosting antioxidants, including flavonoids.
            </p>
          </div>
        </div>

        
      
        <div class="card">
          <div class="content">
          <img src="../img/vegetables.jpg">
            <div class="title">Vegetables</div>
            <p>
            Vegetables provide many of the vitamins and minerals that are essential to our health, 
            we want to guarantee we consume enough of them.
            </p>
          </div>
        </div>

        
      
        <div class="card">
          <div class="content">
          <img src="../img/meat.jpg">
            <div class="title">Meats</div>
            <p>
            Meats are great sources of protein. They also provide lots of other nutrients 
            your body needs, like iodine, iron, zinc, vitamins (especially B12) and essential fatty acids.
            </p>
          </div>
        </div>

        <div class="card">
          <div class="content">
          <img src="../img/eggs.jpg">
            <div class="title">Eggs</div>
            <p>
            Eggs are a very good source of inexpensive, high-quality protein. 
            Eggs are rich sources of selenium, vitamin D, B6, B12 and minerals such as zinc, iron and copper.
            </p>
          </div>
        </div>

        <div class="card">
          <div class="content">
          <img src="../img/milk.jpg">
            <div class="title">Milks</div>
            <p>
            Fruits are an excellent source of essential vitamins and minerals, and they are high in fiber. 
            Fruits also provide a wide range of health-boosting antioxidants, including flavonoids.
            </p>
          </div>
        </div>

        <div class="card">
          <div class="content">
          <img src="../img/fish.jpg">
            <div class="title">Fish</div>
            <p>
            Fruits are an excellent source of essential vitamins and minerals, and they are high in fiber. 
            Fruits also provide a wide range of health-boosting antioxidants, including flavonoids.
            </p>
          </div>
        </div>

        </div>
        </div>
        </section>

        <section class="sec-info">
        
          <div class="about-container" data-aos="fade-up">
   
      <img src="../img/fruits1.jpg"/>
      
      <div class="about-text">
        <p>What is Organic & fresh foods?</p>
        <p>
          Organic foods are grown without artificial pesticides, fertilizers, or herbicides. 
          Organic meat, eggs, and dairy products are obtained from animals that are fed natural 
          feed and not given hormones or antibiotics. Natural foods are free of synthetic or artificial 
          ingredients or additives.
        </p>
      </div>
    </div>

    <div class="about-container" data-aos="fade-left">
      <div class="about-text">
        <p>Why we should eat organic food?</p>
        <p>
        Organic foods often have more beneficial nutrients, such as antioxidants, 
        than their conventionally-grown counterparts and people with allergies to foods, 
        chemicals, or preservatives may find their symptoms lessen or go away when they eat only organic foods. 
        Organic produce contains fewer pesticides.
        </p>
      </div>
      <img src="../img/healthy.jpg"/>
    </div>

    <div class="about-container" data-aos="fade-up-right">
    <img src="../img/farm.jpg"/>
      <div class="about-text">
        <p>why us?</p>
        <p>
        We collect fresh and organic foods directly from farmers without involving any third-party.
        After paying fair price to the farmers, we collect their fresh and organically produced foods.
        So, we can only assure the freshness of the food products.
        </p>
      </div>
      
    </div>
        </section>

        <section class="sec-service" data-aos="zoom-in-up">
        <h1 class="service">Our Services</h1>

        <div class="service-info">
            <div>
            <img src="../img/buy.jpg">
        <h3>Buy fresh and organically produced food products</h3>
        <p>We collect fresh and organically produced food products from the farmers accross the country.
            We don't buy anything that has chemicals on it and produced on inorganic way. 
            There is no third party involved in order to ensure that the farmers get fair price of their hard work.
        </p></div>
        

        <div>
        <img src="../img/sell.jpg">
        <h3>Sell fresh and organic foods</h3>
        <p>Food products that are collected are open for everyone to buy. We are the gurantee of the freshness of
            every food product that you would buy from us.
        </p></div>

        <div>
        <img src="../img/delivery.jpg">
        <h3>Home Delivery</h3>
        <p>Our delivery team will deliver the freshness from the feild to your door step.
            Give us your address and enjoy the freshness of nature on your everyday meals.
        </p>
    </div>
        </div>
        

        </section>
<section class="sec-footer">
          <?php include('../footer.php');?>
          </section>
    


</body>
</html>

<script type="text/javascript">
    var typed = new Typed(".typing", {
        strings: [ "Fruits", "Vegetables", "Meats","Milks","Eggs","Fish"],
        typeSpeed: 100,
        backSpeed: 60,
        loop: true
    });

    
    $(".slider").owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000, //2000ms = 2s;
        autoplayHoverPause: true,
      });

      $(".slider-info").owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000, //2000ms = 2s;
        autoplayHoverPause: true,
      });


</script>