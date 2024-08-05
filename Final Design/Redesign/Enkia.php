<?php

session_start();

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
} else {
    die("UID not found in session.");
}

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://enka.network/api/uid/$uid",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "User-Agent: YourCustomUserAgent",
        "cache-control: no-cache"
    ),
));

$response = curl_exec($curl);
if ($response === false) {
    $err = curl_error($curl);
    die("cURL error: $err");
}

$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ($httpcode != 200) {
    die("API request failed, $httpcode");
}

$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$body = substr($response, $header_size);
$data = json_decode($body, true);
if (!isset($data['uid'])) {
    die("API response no key");
}

curl_close($curl);

$message = json_encode($data, JSON_PRETTY_PRINT);
$message_encoded = json_encode($message);
echo "<script>console.log('$message_encoded');</script>";

$pfpsJson = file_get_contents('json\pfps.json');
$pfpsData = json_decode($pfpsJson, true);

$profileId = $data['playerInfo']['profilePicture']['avatarId'] ?? $data['playerInfo']['profilePicture']['id'];

if (!isset($pfpsData[$profileId])) {
    die("ID not found in the data bruv and i have no fucking idea.");
}

$iconPath = $pfpsData[$profileId]['iconPath'];

$charactersJson = file_get_contents('json\characters.json');
$charactersData = json_decode($charactersJson, true);

if (isset($_SESSION['uid']) && $_SESSION['uid'] !== $uid) {
    unset($_GET['avatarId']);
}

$_SESSION['uid'] = $uid;

$avatarId = $_GET['avatarId'] ?? $data['playerInfo']['showAvatarInfoList'][0]['avatarId'] ?? 705273107;
if (!isset($charactersData[$avatarId])) {
    die("Avatar ID not found in the characters data.");
}

if (!isset($data['avatarInfoList'])) {
    $errorMessage = urlencode('Show additional avatar info is off.');
    header("Location: error.php?error={$errorMessage}");
    exit();
}

$characterData = $charactersData[$avatarId];
$skill1 = $characterData['Skills'][$characterData['SkillOrder'][0]];
$skill2 = $characterData['Skills'][$characterData['SkillOrder'][1]];
$skill3 = $characterData['Skills'][$characterData['SkillOrder'][2]];

$friendshipLevel = null;
foreach ($data['avatarInfoList'] as $avatarInfo) {
    if ($avatarInfo['avatarId'] == $avatarId) {
        $friendshipLevel = $avatarInfo['fetterInfo']['expLevel'];
        break;
    }
}

$characterData = $charactersData[$avatarId];
$const1 = $characterData['Consts'][0];
$const2 = $characterData['Consts'][1];
$const3 = $characterData['Consts'][2];
$const4 = $characterData['Consts'][3];
$const5 = $characterData['Consts'][4];
$const6 = $characterData['Consts'][5];

$weaponType = $characterData['WeaponType'];

$weaponType = str_replace('WEAPON_', '', $weaponType);
$weaponType = ucfirst(strtolower($weaponType));

if ($weaponType == "Pole") {
    $weaponType = "Polearm";
}
elseif ($weaponType == "Sword_one_hand") {
    $weaponType = "Sword";
}

$namecard = "";
$matches_string = "";
preg_match('/S_(.*?)_/', $const1, $matches);
if (isset($matches[1])) {
    $matches_string = implode(", ", $matches);
    $lastComma = strrpos($matches_string, ',');
    if ($lastComma !== false) {
        $matches_string = substr($matches_string, $lastComma + 2);
        if ($matches_string == "PlayerWind") {
            $matches_string = "Traveler";
        }
            
        $videoSource = "Character Namecards\\" . $matches_string . ".mp4";

        if (!file_exists($videoSource)) {
            $videoSource = "Character Namecards\\Default.mp4";
        }
        // Character Namecards
    }
}

$avatarIds = array_map(function($avatarInfo) {
    return $avatarInfo['avatarId'] ?? $avatarInfo['id'];
}, $data['playerInfo']['showAvatarInfoList']);

$sideIconNames = [];
$avatarIdsArray = [];
foreach ($avatarIds as $avatarId) {
    if (isset($charactersData[$avatarId])) {
        $sideIconNames[] = $charactersData[$avatarId]['SideIconName'];
        $avatarIdsArray[] = $avatarId;
    } else {
        echo "sideicon something bruv not work men for avatarId: $avatarId";
    }
}

for ($i = 0; $i < count($sideIconNames); $i++) {
    ${"SideIconName$i"} = $sideIconNames[$i];
    ${"AvatarId$i"} = $avatarIdsArray[$i];
}

$avatarId = $_GET['avatarId'] ?? $data['playerInfo']['showAvatarInfoList'][0]['avatarId'];

$showAvatarInfoList = $data['playerInfo']['showAvatarInfoList'];
$avatarIndex = null;

foreach ($showAvatarInfoList as $index => $avatarInfo) {
    if ($avatarInfo['avatarId'] == $avatarId) {
        $avatarIndex = $index;
        break;
    }
}

$avatarInfoList = $data['avatarInfoList'];
$weaponIcon = null;
$baseAttack = null;
$chargeEfficiency = null;
$relicIcon = null;

$locJson = file_get_contents('json/loc.json');
$locArray = json_decode($locJson, true);

$locArray = $locArray['en'];

foreach ($avatarInfoList as $avatarInfo) { 
    if ($avatarInfo['avatarId'] == $avatarId) {
        $equipList = $avatarInfo['equipList'];
        foreach ($equipList as $equip) {
            if ($equip['flat']['itemType'] == 'ITEM_WEAPON') {
                $weaponLevel = $equip['weapon']['level'];
                if (isset($equip['weapon']['affixMap']) && is_array($equip['weapon']['affixMap'])) {
                    $refinementLevel = reset($equip['weapon']['affixMap']) + 1;
                } else {
                    $refinementLevel = $equip['weapon']['level'];
                }
                $weaponIcon = $equip['flat']['icon'];
                $weaponName = strval($equip['flat']['nameTextMapHash']);
                $weaponName = $locArray[$weaponName];
                $counter = 0;

                $WeaponRarity = $equip['flat']['rankLevel'];

                foreach ($equip['flat']['weaponStats'] as $stat) {
                    $counter++;
                    if ($counter == 1 && $stat['appendPropId'] == 'FIGHT_PROP_BASE_ATTACK') {
                        $baseAttack = $stat['statValue'];
                    }
                    if ($counter == 2) {
                        $statIcon = $stat['appendPropId'];
                        $baseBuffType = $stat['statValue'];
                        break;
                    }
                }
                break 2;
            }
        }
    }
}

$artifacts = [];
$counter = 1;

foreach ($avatarInfoList as $avatarInfo) { 
    if ($avatarInfo['avatarId'] == $avatarId) {
        $equipList = $avatarInfo['equipList'];
        foreach ($equipList as $equip) {
            if ($equip['flat']['itemType'] == 'ITEM_RELIQUARY') {
                $artifact = [];
                $artifact['icon'] = $equip['flat']['icon'];
                $artifact['type'] = $equip['flat']['equipType'];
                $artifact['rankLevel'] = $equip['flat']['rankLevel'];
                $artifact['mainStat'] = $equip['flat']['reliquaryMainstat'];
                $artifact['subStats'] = array_key_exists('reliquarySubstats', $equip['flat']) ? $equip['flat']['reliquarySubstats'] : null;
                $artifacts[] = $artifact;
            }
        }
    }
}

foreach ($artifacts as $artifact) {
    ${"Artifacticon".$counter} = $artifact['icon'];
    ${"Artifacttype".$counter} = $artifact['type'];
    ${"ArtifactrankLevel".$counter} = $artifact['rankLevel'];
    ${"ArtifactmainStat".$counter} = $artifact['mainStat'];
    ${"ArtifactsubStats".$counter} = $artifact['subStats'];

    for ($index = 0; $index < 4; $index++) {
        if (isset(${"ArtifactsubStats".$counter}[$index])) {
            ${"appendPropId".$counter.$index} = ${"ArtifactsubStats".$counter}[$index]['appendPropId'];
            ${"statValue".$counter.$index} = ${"ArtifactsubStats".$counter}[$index]['statValue'];
        }
    }

    $counter++;
}

$mainPropId0 = !empty($artifacts[0]['mainStat']['mainPropId']) ? $artifacts[0]['mainStat']['mainPropId'] : null;
$mainPropId1 = !empty($artifacts[1]['mainStat']['mainPropId']) ? $artifacts[1]['mainStat']['mainPropId'] : null;
$mainPropId2 = !empty($artifacts[2]['mainStat']['mainPropId']) ? $artifacts[2]['mainStat']['mainPropId'] : null;
$mainPropId3 = !empty($artifacts[3]['mainStat']['mainPropId']) ? $artifacts[3]['mainStat']['mainPropId'] : null;
$mainPropId4 = !empty($artifacts[4]['mainStat']['mainPropId']) ? $artifacts[4]['mainStat']['mainPropId'] : null;

$avatarInfoList = $data['avatarInfoList'];
$locData = json_decode(file_get_contents('json\characters.json'), true);

foreach ($avatarInfoList as $avatarInfo) {
    if ($avatarInfo['avatarId'] == $avatarId) {
        $propMap = $avatarInfo['propMap'];
        $fightPropMap = $avatarInfo['fightPropMap'];
        if (array_key_exists('talentIdList', $avatarInfo)) {
            $UnlockedConstel = $avatarInfo['talentIdList'];
        } else {
            $UnlockedConstel = null;
        }

        $hp = number_format(intval($fightPropMap[2000]));
        $baseAtk = intval($fightPropMap[2001]);
        $baseDef = intval($fightPropMap[2002]);
        $elementalMastery = intval($fightPropMap[28]);
        $critRate = number_format($fightPropMap[20] * 100, 1) . "%";
        $critDmg = number_format($fightPropMap[22] * 100, 1) . "%";
        $energyRecharge = number_format($fightPropMap[23] * 100, 1) . "%";
        $ShieldStrength = !empty($fightPropMap[81]) ? number_format($fightPropMap[81] * 100, 1) . "%" : "0%";
        $HealingBonus = number_format($fightPropMap[26] * 100, 1) . "%";
        $elements = ["Pyro", "Electro", "Hydro", "Dendro", "Anemo", "Geo", "Cryo"];
        $elementKeys = [40, 41, 42, 43, 44, 45, 46];
        
        $elementName = null;
        $elementalBonus = null;
        for ($i = 0; $i < count($elements); $i++) {
            if ($fightPropMap[$elementKeys[$i]] != 0) {
                $elementName = $elements[$i];
                $elementalBonus = number_format($fightPropMap[$elementKeys[$i]] * 100, 1) . "%";
                break;
            }
        }

        $elementNameMapping = [
            "Ice" => "Cryo",
            "Fire" => "Pyro",
            "Electric" => "Electro",
            "Wind" => "Anemo",
            "Grass" => "Dendro",
            "Rock" => "Geo",
            "Water" => "Hydro",
        ];
        
        if ($elementName === null) {
            if (isset($locData[$avatarId])) {
                $elementName = $locData[$avatarId]['Element'];
                if (isset($elementNameMapping[$elementName])) {
                    $elementName = $elementNameMapping[$elementName];
                }
            }
        }

        $CharacterElement = $locData[$avatarId]['Element'];

        if (isset($elementNameMapping[$CharacterElement])) {
            $CharacterElement = $elementNameMapping[$CharacterElement];
        }

        $numberOfKeys = 0;

        if (is_array($UnlockedConstel)) {
            $numberOfKeys = count($UnlockedConstel);
        }
        

        $TalentLevels = array_values($avatarInfo['skillLevelMap']);

        $Talent1 = $TalentLevels[0];
        $Talent2 = $TalentLevels[1];
        $Talent3 = $TalentLevels[2];

        break;
    }
}

$allowed_values = array("FIGHT_PROP_ATTACK", "FIGHT_PROP_HP", "FIGHT_PROP_DEFENSE", "FIGHT_PROP_BASE_ATTACK", "FIGHT_PROP_ELEMENT_MASTERY", "FIGHT_PROP_ATTACK");

function printValue($mainPropId, $value) {
    global $allowed_values;
    if (!in_array($mainPropId, $allowed_values)) {
        echo $value . '%';
    } else {
        print_r($value);
    }
}

function displayStatValue($appendPropId, $statValue, $allowed_values) {
    if (!in_array($appendPropId, $allowed_values)) {
        return $statValue . "%";
    } else {
        return $statValue;
    }
}

$json = file_get_contents('json/namecards.json'); // for getting namecards bruv
$namecards = json_decode($json, true);
$namecardPath = null;

if (isset($data['playerInfo']['nameCardId'])) {
    $id = $data['playerInfo']['nameCardId'];
    if (isset($namecards[$id])) {
        $CurrentNameCard = $namecards[$id]['icon'];
    }
}

if (isset($data['playerInfo']['showNameCardIdList'])) {
    for ($i=0; $i <= 8 ; $i++) { 
        $varName = 'namecard'.($i+1);
        if (isset($data['playerInfo']['showNameCardIdList'][$i])) {
            $id = $data['playerInfo']['showNameCardIdList'][$i];
            if (isset($namecards[$id])) {
                $$varName = $namecards[$id]['icon'];
            } else {
                $$varName = null;
            }
        } else {
            $$varName = null;
        }
    }
}