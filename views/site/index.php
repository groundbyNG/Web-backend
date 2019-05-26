<?php
use app\assets\IndexAsset;
IndexAsset::register($this);
$this->title = 'Main page';
?>

<div class="display-container main-content">
      <div class="shade">
        <div class="main-content__title-container">
          <h1 class="title-container__title">
            Revolutionary innovation in the auto industry
          </h1>
        </div>
        <div class="main-content__links-container">
          <div
            class="links-container__link-container col-lg-4 col-md-4 col-sm-4"
          >
            <a href="./contacts.html" class="link-container__link">Contacts</a>
          </div>
          <div
            class="links-container__link-container col-lg-4 col-md-4 col-sm-4"
          >
            <a href="./about-us.html" class="link-container__link">About us</a>
          </div>
          <div
            class="links-container__link-container col-lg-4 col-md-4 col-sm-4"
          >
            <a href="./products.html" class="link-container__link"
              >Choose a car...</a
            >
          </div>
        </div>
      </div>
    </div>