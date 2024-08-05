<?php

require_once 'Enkia.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Artiseeker</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="genshin-impact.css">
</head>
<body>

<nav class="text-white navbar navbar-expand-lg navbar-light bg-transparent navbar fixed-top" style="z-index: 5; background-color: #262626; transition: background-color 0.25s ease;">
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto ml-auto" style="margin-left: 1%;">
      <li class="nav-item active">
        <a style="font-size: 2em;" class="position-relative nav-link text-white navbar-brand mb-0 h1" href="http://localhost/Almost-there-7dc27e8bb979-4428dba34ff3/Final%20Design/Index.php">
          <img src="artiseekerLogo.png" alt="Artiseeker Logo" style="height: 50px; width: 50px;">
          Artiseeker
        </a>
      </li>
      <li class="nav-item mr-3">
        <a style="margin-top: 15%" class="nav-link text-white navbar-brand mb-0 h1 fs-5" href="http://localhost/Almost-there-7dc27e8bb979-4428dba34ff3/Final%20Design/Index.php">Profile</a>
      </li>
      <li class="nav-item mr-3">
        <a style="margin-top: 25%" class="nav-link text-white navbar-brand mb-0 h1 fs-5" href="https://api.enka.network/#/">API</a>
      </li>
    </ul>
  </div>
</nav>


<div class="parallax" style="height: 25vh;"></div>

<div class="align-bottom text-white fs-3" style="position: relative; z-index: 1;"> <!-- profile picture -->
    <img src="https://enka.network/ui/<?php echo $iconPath; ?>.png" style="border: 3px solid white; border-radius: 50%; margin-top: -8%; margin-left: 15%; width: 150px; height: 150px; background-color: #d19e78;">
    <div class="align-bottom text-white fs-4" style="display: flex; align-items: center; position: relative; z-index: 1; margin-top: -9%; margin-left: 26%">
        <p style="margin-top: 5%; margin-left: 1%"><?php 
                echo !empty($data['playerInfo']['signature']) ? $data['playerInfo']['signature'] : ''; 
            ?>
          </p>
    </div>
    <div class="align-bottom text-white fs-4" style="display: flex; align-items: center; position: relative; z-index: 1; margin-top: -6%; margin-left: 26%">
        <p style="margin-top: -0.5%; margin-left: 1%"><?php echo $data['playerInfo']['nickname']; ?></p>
        <p style="font-size: 15px; margin-top: -0.5%; margin-left: 1%; padding-left: 8px; padding-right: 8px; border-radius: 4px; background-color: #96db83;"><?php echo $data['playerInfo']['level']; ?></p>
    </div>
    <div class="position-relative" style="margin-left: 87%; margin-top: -1%;"> 
    <form>
      <a href="#" onClick="event.preventDefault(); location.reload();">
      <div style="margin-left: 25%; display: inline-block; position: relative; z-index: 9999;">
        <img src="Refresh_icon.png" height="20px" width="20px" style="filter: brightness(0) invert(1);">
        <input type="button" value="Refresh" style="background: transparent; color: white; border: none; font-size: 20px">
      </div>
      </a>
    </form>
  </div>
</div>

<div class="text-white fs-6" style="display: flex; align-items: center; position: relative; z-index: 1; margin-top: 0%; margin-left: 25%">
  <p style="margin-top: 1.5%; margin-left: 1%">
    Adventure Rank:&nbsp; 
    <?php echo $data['playerInfo']['level']; ?> 
    &nbsp; / &nbsp; 
    World Level: &nbsp; 
    <?php echo $data['playerInfo']['worldLevel']; ?> 
    &nbsp; / &nbsp; 
    Total Achivements 
    <?php echo $data['playerInfo']['finishAchievementNum']; ?> 
    &nbsp; / &nbsp; 
    Floor 
    <?php echo $data['playerInfo']['towerFloorIndex'] ?> 
    Chamber 
    <?php echo $data['playerInfo']['towerLevelIndex'] ?>
  </p>
</div>

<div class="align-bottom text-white fs-3" style="display: flex; align-items: center; position: relative; z-index: 1; margin-top: 2%; margin-left: 15%">
  <img src="star.png" alt="Star Image" height="45px" width="45px">
  <p style="margin-top: 1.5%; margin-left: 1%" >My Characters</p>
</div>

<div class="position-absolute w-100" style="margin-top: 15px; border-top: 110px solid #262626; box-shadow: 0px 0px 10px 5px rgba(0,0,0,0.05);"></div>
<!-- line -->

<div class="container" style="position: relative; top: -50px;">
    <div class="d-flex justify-content-center mt-5">
        <?php 
        for ($i = 0; $i <= 7; $i++) { 
            $iconName = "SideIconName" . $i;
            if (!empty($$iconName)) { ?>
                <a href="Character.php?uid=<?php echo $uid; ?>&avatarId=<?php echo $data['playerInfo']['showAvatarInfoList'][$i]['avatarId'] ?>" class="mx-1" style="text-decoration: none;">
                    <img src="https://enka.network/ui/<?php echo $$iconName; ?>.png" class="img-fluid" style="width: 105px; height: 105px">
                    <p class="position-relative" style="margin-top: -12.5%; left: 62.5px; color: white;">
                      <?php echo $level = $data['playerInfo']['showAvatarInfoList'][$i]['level']; ?>
                  </p>
                </a>
            <?php } 
        } ?>
    </div>
</div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10" style="flex: 0 0 87.5%; max-width: 87.5%;">
      <video src="<?php echo $videoSource; ?>" class="img-fluid" autoplay loop></video>
    </div>
  </div>
</div>

<div class="align-bottom text-white text-center mt-4" style="position: relative; z-index: 1;">
  <p>Currently not all Character cards are animated</p>
</div>

<div class="position-absolute w-100" style="margin-top: 1%; border-top: 120px solid #262626; box-shadow: 0px 0px 10px 5px rgba(0,0,0,0.05);"></div>

<!-- beggining of character stats -->

<div class="position relative text-white" style="margin-top: -38%; margin-left: 13.5%">
  <p>
    <?php echo $uid . ' &nbsp;<span style="font-size:15px;">&bull;</span>&nbsp; ' . $data['playerInfo']['nickname']; ?>
  </p>
</div>

<div class="position-relative text-white" style="margin-top: 0%; margin-left: 13.5%; font-size: 24px;">
  <?php echo "<p style='font-size: 35px;'>{$matches_string}</p>"; ?>
</div>
<div class="position-relative text-white" style="margin-top: -1%; margin-left: 13.5%; font-size: 20px;">
  <?php echo $data['playerInfo']['showAvatarInfoList'][$avatarIndex]['level'] . "/" ?> <span class="position-relative text-white" style="color: #99a9b1 !important; margin-left: -4px; font-size: 16px !important;">90</span>
</div>
<div>
  <img class="position-relative text-white" src="statIcon/Friendship.svg" width="20px" height="20px" style="filter: brightness(0) invert(1); margin-left: 13.5%;">
  <span class="position-relative text-white" style="font-size: 16px;"><?php echo $friendshipLevel ?></span>
</div>

<div style="margin-left: 34%; margin-top: -8%">
  <img src="https://enka.network/ui/<?php echo $const1; ?>.png" width="40px" height="40px">
  <?php
    if ($numberOfKeys < 1) {
      echo '<img style="z-index: 9999; position: absolute; margin-left: -2.8%; width: 45px; height: 45px; border-radius: 50%; " src="Images\lock.png">';
    }
  ?>
</div>
<div style="margin-left: 34%; margin-top: 0.5%">
  <img src="https://enka.network/ui/<?php echo $const2; ?>.png" width="40px" height="40px">
  <?php
    if ($numberOfKeys < 2) {
      echo '<img style="z-index: 9999; position: absolute; margin-left: -2.8%; width: 45px; height: 45px; border-radius: 50%; " src="Images\lock.png">';
    }
  ?>
</div>
<div style="margin-left: 34%; margin-top: 0.5%">
  <img src="https://enka.network/ui/<?php echo $const3; ?>.png" width="40px" height="40px">
  <?php
    if ($numberOfKeys < 3) {
      echo '<img style="z-index: 9999; position: absolute; margin-left: -2.8%; width: 45px; height: 45px; border-radius: 50%; " src="Images\lock.png">';
    }
  ?>
</div>
<div style="margin-left: 34%; margin-top: 0.5%">
  <img src="https://enka.network/ui/<?php echo $const4; ?>.png" width="40px" height="40px">
  <?php
    if ($numberOfKeys < 4) {
      echo '<img style="z-index: 9999; position: absolute; margin-left: -2.8%; width: 45px; height: 45px; border-radius: 50%; " src="Images\lock.png">';
    }
  ?>
</div>
<div style="margin-left: 34%; margin-top: 0.5%">
  <img src="https://enka.network/ui/<?php echo $const5; ?>.png" width="40px" height="40px">
  <?php
    if ($numberOfKeys < 5) {
      echo '<img style="z-index: 9999; position: absolute; margin-left: -2.8%; width: 45px; height: 45px; border-radius: 50%; " src="Images\lock.png">';
    }
  ?>
</div>
<div style="margin-left: 34%; margin-top: 0.5%">
  <img src="https://enka.network/ui/<?php echo $const6; ?>.png" width="40px" height="40px">
  <?php
    if ($numberOfKeys < 6) {
        echo '<img style="z-index: 9999; position: absolute; margin-left: -2.8%; width: 45px; height: 45px; border-radius: 50%; " src="Images\lock.png">';
    }
  ?>
</div>


<!-- start of weapon stats -->

<div class="position relative" style="margin-top: -11%; margin-left: 37.5%">
  <img src="https://enka.network/ui/<?php echo $weaponIcon; ?>.png" width="155px" height="155px">
  <?php
  if  ($WeaponRarity == 1) {
    echo '<img style="margin-top: 9.5%; margin-left: -9%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
  }
  if  ($WeaponRarity == 2) {
    echo '<img style="margin-top: 9.5%; margin-left: -9%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -7.5%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
  }
  if  ($WeaponRarity == 3) {
    echo '<img style="margin-top: 9.5%; margin-left: -9%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -7.5%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -6%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
  }
  if  ($WeaponRarity == 4) {
    echo '<img style="margin-top: 9.5%; margin-left: -9%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -7.5%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -6%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -4.5%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
  }
  if  ($WeaponRarity == 5) {
    echo '<img style="margin-top: 9.5%; margin-left: -9%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -7.5%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -6%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -4.5%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
    echo '<img style="margin-top: 9.5%; margin-left: -3%" class="position-absolute" src="statIcon\star.webp" width="30px" height="30px">';
  }
  ?>
</div>

<div class="position-relative text-white" style="margin-top: 2.5%; margin-left: 37%; font-size: 16px;">
  <?php echo $weaponName; ?>
</div>

<div class="position relative" style="margin-top: 0.5%; margin-left: 37%; color: #99a9b1 !important; font-size: 14px;">
  <?php echo $weaponType; ?></p>
</div>

<div class="position relative text-white" style="margin-top: 1%; margin-left: 37%">
  <img src="statIcon\FIGHT_PROP_ATTACK.svg" style="filter: invert(1); height: 23px; width: 23px;">
  <?php echo $baseAttack; ?>
</div>

<div class="position relative text-white" style="margin-top: -1.7%; margin-left: 42%">
  <img class="invert" style="width: 23px; height: 23px; margin-left: 0px; filter: invert(1);" src="<?php echo 'statIcon/' . $statIcon . '.svg'; ?>">
  <?php echo isset($baseBuffType) ? $baseBuffType . "%" : null; ?>
</div>

<div class="position relative text-white" style="margin-top: 1%; margin-left: 37%; font-size: 22px">
  <?php echo "R" . $refinementLevel; ?>
</div>

<div class="position relative text-white" style="margin-top: -2.1%; margin-left: 40%; font-size: 22px">
  <?php echo "Lv. " . $weaponLevel; ?>
  <span style="color: #99a9b1; margin-left: -4px">/90</span>
</div>

<!-- end of weapon stats -->

<div class="position relative text-white" style="margin-top: -29%; margin-left: 38%">
  <img src="https://enka.network/ui/<?php echo $skill1; ?>.png" style="height: 40px; width: 40px;">
  <p style="margin-left: 1.40%; margin-top: 2%;"><?php echo $Talent1; ?></p>
</div>

<div class="position relative text-white" style="margin-top: -6.5%; margin-left: 41.5%">
  <img src="https://enka.network/ui/<?php echo $skill2; ?>.png" style="height: 40px; width: 40px;">
  <p style="margin-left: 1.40%; margin-top: 2%;"><?php echo $Talent2; ?></p>
</div>

<div class="position relative text-white" style="margin-top: -6.4%; margin-left: 45%">
  <img src="https://enka.network/ui/<?php echo $skill3; ?>.png" style="height: 40px; width: 40px;">
  <p style="margin-left: 1.40%; margin-top: 2%;"><?php echo $Talent3; ?></p>
</div>


<div style="position: relative; left: 0%; margin-top: -6%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_HP.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">HP</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_ATTACK.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">ATK</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_DEFENSE.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">DEF</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_ELEMENT_MASTERY.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.5%; color: white;">Elemental Mastery</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_CRITICAL.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">Crit Rate</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_CRITICAL_HURT.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">Crit DMG</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_CHARGE_EFFICIENCY.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">Energy Recharge</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
  <img class="img-fluid mx-auto d-block" style="filter: brightness(0) invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_<?php echo $elementName; ?>_ADD_HURT.svg" alt="it broke">
  <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">Hydro DMG Bonus</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_SHIELD_COST_MINUS_RATIO.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">Healing Bonus</p>
</div>
<div style="position: relative; left: 0%; margin-top: 1.4%">
    <img class="img-fluid mx-auto d-block" style="filter: invert(1); width:20px; height:20px; margin-top: -0%;" src="statIcon\FIGHT_PROP_HEAL_ADD.svg">
    <p style="text-align: left; margin-left: 51.5%; margin-top: -1.3%; color: white;">Shield Strength</p>
</div>

<div class="position-relative text-white" style="right: 33%; margin-top: -29.75%; text-align: right;">
  <p><?php echo $hp ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1%; text-align: right;">
  <p><?php echo $baseAtk ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1.4%; text-align: right;">
  <p><?php echo $baseDef ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1.9%; text-align: right;">
  <p><?php echo $elementalMastery ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1.5%; text-align: right;">
  <p><?php echo $critRate ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1.5%; text-align: right;">
  <p><?php echo $critDmg ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1.6%; text-align: right;">
  <p><?php echo $energyRecharge ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1%; text-align: right;">
  <p><?php echo isset($elementalBonus) ? $elementalBonus : '0%'; ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1.5%; text-align: right;">
  <p><?php echo $ShieldStrength ?></p>
</div>
<div class="position-relative text-white" style="right: 33%; margin-top: 1.5%; text-align: right;">
  <p><?php echo $HealingBonus ?></p>
</div>


<!-- start of artifacts stats -->

<div class="container" style="margin-left: 68.2%; margin-top: -30.5%;">
  <div class="position-relative p-3" style="background: rgba(0, 0, 0, 0.2); width: 275px; height: 85px;">
  <?php if(isset($Artifacticon1) && !empty($Artifacticon1)): ?>
    <img style="margin-top: -10%; margin-left: -8%; opacity: 0.5;" src="https://enka.network/ui/<?php echo $Artifacticon1?>.png" height="95" width="95" class="position-relative">
    
    <div class="position-relative" style="height: 125%; width: 1px; background-color: rgba(255, 255, 255, 0.4); margin-top: -32%; margin-left: 31.5%;"></div>

    <p style="z-index: 9999; margin-top: -7%; margin-left: 2%; text-align: right; right: 72%;" class="text-white position-relative">
    <img style="margin-top: -2.5px; filter: invert(1);" src="<?php echo 'statIcon/' . $mainPropId0; ?>" height="17" width="17">
      <?php if (isset($artifacts[0]['mainStat']['statValue']) && !empty($artifacts[0]['mainStat']['statValue'])) printValue($mainPropId0, $artifacts[0]['mainStat']['statValue']); ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -35%; margin-left: 37%; font-size: 14px;">
        <?php 
        if(isset($appendPropId10)) {
            echo '<img style="margin-top: -2.5px; !important; filter: invert(1);" src="statIcon/' . $appendPropId10 . '" height="17" width="17">';
        }
        if(isset($appendPropId10) && isset($statValue10) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId10, $statValue10, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId11)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId11 . '" height="17" width="17">';
        }
        if(isset($appendPropId11) && isset($statValue11) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId11, $statValue11, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: 5%; margin-left: 36.5%; font-size: 14px;">
        <?php 
        if(isset($appendPropId12)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId12 . '" height="17" width="17">';
        }
        if(isset($appendPropId12) && isset($statValue12) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId12, $statValue12, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId13)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId13 . '" height="17" width="17">';
        }
        if(isset($appendPropId13) && isset($statValue13) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId13, $statValue13, $allowed_values); 
        }
        ?>
    </p>

  <?php endif; ?>
  </div>
</div>

<div class="container" style="margin-left: 68.2%; margin-top: 0.5%;">
  <div class="position-relative p-3" style="background: rgba(0, 0, 0, 0.2); width: 275px; height: 85px;">
  <?php if(isset($Artifacticon2) && !empty($Artifacticon2)): ?>
    <img style="margin-top: -10%; margin-left: -8%; opacity: 0.5;" src="https://enka.network/ui/<?php echo $Artifacticon2?>.png" height="95" width="95" class="position-relative">
    
    <div class="position-relative" style="height: 125%; width: 1px; background-color: rgba(255, 255, 255, 0.4); margin-top: -32%; margin-left: 31.5%;"></div>

    <p style="z-index: 9999; margin-top: -7%; margin-left: 2%; text-align: right; right: 72%;" class="text-white position-relative">
    <img style="margin-top: -2.5px; filter: invert(1); text-align: right; right: 21.1%;" src="<?php echo 'statIcon/' . $mainPropId0; ?>" height="17" width="17">
      <?php if (isset($artifacts[1]['mainStat']['statValue']) && !empty($artifacts[1]['mainStat']['statValue'])) printValue($mainPropId0, $artifacts[1]['mainStat']['statValue']); ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -35%; margin-left: 37%; font-size: 14px;">
        <?php 
        if(isset($appendPropId20)) {
            echo '<img style="margin-top: -2.5px; !important; filter: invert(1);" src="statIcon/' . $appendPropId20 . '" height="17" width="17">';
        }
        if(isset($appendPropId20) && isset($statValue20) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId20, $statValue20, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId21)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId21 . '" height="17" width="17">';
        }
        if(isset($appendPropId21) && isset($statValue21) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId21, $statValue21, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: 5%; margin-left: 36.5%; font-size: 14px;">
        <?php 
        if(isset($appendPropId22)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId22 . '" height="17" width="17">';
        }
        if(isset($appendPropId22) && isset($statValue22) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId22, $statValue22, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId23)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId23 . '" height="17" width="17">';
        }
        if(isset($appendPropId23) && isset($statValue23) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId23, $statValue23, $allowed_values); 
        }
        ?>
    </p>

  <?php endif; ?>
  </div>
</div>
<div class="container" style="margin-left: 68.2%; margin-top: 0.5%;">
  <div class="position-relative p-3" style="background: rgba(0, 0, 0, 0.2); width: 275px; height: 85px;">
  <?php if(isset($Artifacticon3) && !empty($Artifacticon3)): ?>
    <img style="margin-top: -10%; margin-left: -8%; opacity: 0.5;" src="https://enka.network/ui/<?php echo $Artifacticon3?>.png" height="95" width="95" class="position-relative">
    
    <div class="position-relative" style="height: 125%; width: 1px; background-color: rgba(255, 255, 255, 0.4); margin-top: -32%; margin-left: 31.5%;"></div>

    <p style="z-index: 9999; margin-top: -7%; margin-left: 2%; text-align: right; right: 72%;" class="text-white position-relative">
    <img style="margin-top: -2.5px; filter: invert(1);" src="<?php echo 'statIcon/' . $mainPropId2; ?>" height="17" width="17">
      <?php if (isset($artifacts[2]['mainStat']['statValue']) && !empty($artifacts[2]['mainStat']['statValue'])) printValue($mainPropId0, $artifacts[2]['mainStat']['statValue']); ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -35%; margin-left: 37%; font-size: 14px;">
        <?php 
        if(isset($appendPropId30)) {
            echo '<img style="margin-top: -2.5px; !important; filter: invert(1);" src="statIcon/' . $appendPropId30 . '" height="17" width="17">';
        }
        if(isset($appendPropId30) && isset($statValue30) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId30, $statValue30, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId31)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId31 . '" height="17" width="17">';
        }
        if(isset($appendPropId31) && isset($statValue31) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId31, $statValue31, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: 5%; margin-left: 36.5%; font-size: 14px;">
        <?php 
        if(isset($appendPropId32)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId32 . '" height="17" width="17">';
        }
        if(isset($appendPropId32) && isset($statValue32) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId32, $statValue32, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId33)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId33 . '" height="17" width="17">';
        }
        if(isset($appendPropId33) && isset($statValue33) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId33, $statValue33, $allowed_values); 
        }
        ?>
    </p>

  <?php endif; ?>
  </div>
</div>

<div class="container" style="margin-left: 68.2%; margin-top: 0.5%;">
  <div class="position-relative p-3" style="background: rgba(0, 0, 0, 0.2); width: 275px; height: 85px;">
  <?php if(isset($Artifacticon1) && !empty($Artifacticon1)): ?>
    <img style="margin-top: -10%; margin-left: -8%; opacity: 0.5;" src="https://enka.network/ui/<?php echo $Artifacticon4?>.png" height="95" width="95" class="position-relative">
    
    <div class="position-relative" style="height: 125%; width: 1px; background-color: rgba(255, 255, 255, 0.4); margin-top: -32%; margin-left: 31.5%;"></div>

    <p style="z-index: 9999; margin-top: -7%; margin-left: 2%; text-align: right; right: 72%;" class="text-white position-relative">
    <img style="margin-top: -2.5px; filter: brightness(0) invert(1);" src="<?php echo 'statIcon/' . $mainPropId3; ?>" height="17" width="17">
      <?php if (isset($artifacts[3]['mainStat']['statValue']) && !empty($artifacts[3]['mainStat']['statValue'])) printValue($mainPropId0, $artifacts[3]['mainStat']['statValue']); ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -35%; margin-left: 37%; font-size: 14px;">
        <?php 
        if(isset($appendPropId40)) {
            echo '<img style="margin-top: -2.5px; !important; filter: invert(1);" src="statIcon/' . $appendPropId40 . '" height="17" width="17">';
        }
        if(isset($appendPropId40) && isset($statValue40) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId40, $statValue40, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId41)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId41 . '" height="17" width="17">';
        }
        if(isset($appendPropId41) && isset($statValue41) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId41, $statValue41, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: 5%; margin-left: 36.5%; font-size: 14px;">
        <?php 
        if(isset($appendPropId42)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId42 . '" height="17" width="17">';
        }
        if(isset($appendPropId42) && isset($statValue42) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId42, $statValue42, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId43)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId43 . '" height="17" width="17">';
        }
        if(isset($appendPropId43) && isset($statValue43) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId43, $statValue43, $allowed_values); 
        }
        ?>
    </p>

  <?php endif; ?>
  </div>
</div>

<div class="container" style="margin-left: 68.2%; margin-top: 0.5%;">
  <div class="position-relative p-3" style="background: rgba(0, 0, 0, 0.2); width: 275px; height: 85px;">
  <?php if(isset($Artifacticon1) && !empty($Artifacticon1)): ?>
    <img style="margin-top: -10%; margin-left: -8%; opacity: 0.5;" src="https://enka.network/ui/<?php echo $Artifacticon5?>.png" height="95" width="95" class="position-relative">
    
    <div class="position-relative" style="height: 125%; width: 1px; background-color: rgba(255, 255, 255, 0.4); margin-top: -32%; margin-left: 31.5%;"></div>

    <p style="z-index: 9999; margin-top: -7%; margin-left: 2%; text-align: right; right: 72%;" class="text-white position-relative">
    <img style="margin-top: -2.5px; filter: invert(1);" src="<?php echo 'statIcon/' . $mainPropId4; ?>" height="17" width="17">
      <?php if (isset($artifacts[4]['mainStat']['statValue']) && !empty($artifacts[4]['mainStat']['statValue'])) printValue($mainPropId0, $artifacts[4]['mainStat']['statValue']); ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -35%; margin-left: 37%; font-size: 14px;">
        <?php 
        if(isset($appendPropId50)) {
            echo '<img style="margin-top: -2.5px; !important; filter: invert(1);" src="statIcon/' . $appendPropId50 . '" height="17" width="17">';
        }
        if(isset($appendPropId50) && isset($statValue50) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId50, $statValue50, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId51)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId51 . '" height="17" width="17">';
        }
        if(isset($appendPropId51) && isset($statValue51) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId51, $statValue51, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: 5%; margin-left: 36.5%; font-size: 14px;">
        <?php 
        if(isset($appendPropId52)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId52 . '" height="17" width="17">';
        }
        if(isset($appendPropId52) && isset($statValue52) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId52, $statValue52, $allowed_values); 
        }
        ?>
    </p>

    <p class="position-relative text-white" style="z-index: 4; margin-top: -15.5%; margin-left: 70%; font-size: 14px;">
        <?php 
        if(isset($appendPropId53)) {
            echo '<img style="margin-top: -2.5px; font-size: 14px !important; filter: invert(1);" src="statIcon/' . $appendPropId53 . '" height="17" width="17">';
        }
        if(isset($appendPropId53) && isset($statValue53) && isset($allowed_values)) {
            echo " " . displayStatValue($appendPropId53, $statValue53, $allowed_values); 
        }
        ?>
    </p>

  <?php endif; ?>
  </div>
</div>

<!-- end of character stats -->

<p style="margin-top: 100px;"></p> <!-- to make the page scrollable -->

<script>
$(document).ready(function() {
    if (localStorage.scrollPosition) {
        $(window).scrollTop(localStorage.scrollPosition);
    }

    $(window).scroll(function() {
        localStorage.scrollPosition = $(this).scrollTop();
    });
});

$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    if (scroll >= 170) {
        $(".navbar").removeClass("bg-transparent");
    } else {
        $(".navbar").addClass("bg-transparent");
    }
});

</script>

</body>
</html>