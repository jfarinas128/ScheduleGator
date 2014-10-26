<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.ico">
    <title>Courses Offered</title>
    <?php $this->load->view('template/header_files'); ?>
    <!--<link href="<?php echo base_url();?>assets/css/bootstrap-checkbox.css" rel="stylesheet">-->
    <link href="<?php echo base_url();?>assets/css/signin.css" rel="stylesheet">

</head>

<body  >
    <?php 
    	if($this->tank_auth->is_logged_in())
			$this->load->view('template/navbar');
		else  
			$this->load->view('template/navbar_unlogged');
    ?>
    <div class="container">
        <div class="jumbotron">
            <div style="text-align: center;">
                <br><h2><font face="chicago">Courses Offered</font></h2></br>
                <p>Enter a Course Number, Section Number, Course Prefix, or Professor's Name</p>
            </div>
            <div class="row col-md-12">
                <form action='<?php echo base_url();?>courses/search' method='post' id='coursesearch' role="form" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-5">
                            <!--<input type="checkbox"class="checkbox"name="professor" value="prof"> Professor Name<br>-->
                            <br><input class="btn btn-search col-md-4" type="submit" value="Search" style="float: right" />
                            <div style="overflow: hidden; padding-right: .5em;">
                                <input name="query" class="form-control" type="text" style="width: 100%;" />
                            </div>
                            <br/>
                            <p>OR</p>
                            <p>Search by Department for a list of Courses</p>
                            <select class="form-control" name="DEPT" onchange="this.form.submit()">
                                <option value="">SELECT A DEPARTMENT</option>
                                <option value="ACCOUNTING">ACCOUNTING</option>
                                <option value="ADVERTISING">ADVERTISING</option>
                                <option value="AFRICAN AMERICAN STUDIES">AFRICAN AMERICAN STUDIES</option>
                                <option value="AFRICAN STUDIES">AFRICAN STUDIES</option>
                                <option value="AGRICULTURAL & BIOLOG ENGINEERING">AGRICULTURAL & BIOLOG ENGINEERING</option>
                                <option value="AGRICULTURAL EDUCA & COMMUNICA">AGRICULTURAL EDUCA & COMMUNICA</option>
                                <option value="AGRICULTURAL OPERATIONS MANAGE">AGRICULTURAL OPERATIONS MANAGE</option>
                                <option value="AGRICULTURE">AGRICULTURE</option>
                                <option value="AGRONOMY">AGRONOMY</option>
                                <option value="ANIMAL SCIENCES">ANIMAL SCIENCES</option>
                                <option value="ANTHROPOLOGY">ANTHROPOLOGY</option>
                                <option value="APPLIED PHYSIOLOGY & KINESIOLOGY">APPLIED PHYSIOLOGY & KINESIOLOGY</option>
                                <option value="ARCHITECTURE">ARCHITECTURE</option>
                                <option value="ART AND ART HISTORY">ART AND ART HISTORY</option>
                                <option value="ASTRONOMY">ASTRONOMY</option>
                                <option value="BEHAVIORAL SCI & COMMUNITY HLH">BEHAVIORAL SCI & COMMUNITY HLH</option>
                                <option value="BIOLOGY-BIOLOGICAL SCIENCES">BIOLOGY-BIOLOGICAL SCIENCES</option>
                                <option value="BIOLOGY-BOTANY">BIOLOGY-BOTANY</option>
                                <option value="BIOLOGY-ZOOLOGY">BIOLOGY-ZOOLOGY</option>
                                <option value="BIOMEDICAL ENGINEERING">BIOMEDICAL ENGINEERING</option>
                                <option value="BIOSTATISTICS">BIOSTATISTICS</option>
                                <option value="BUILDING CONSTRUCTION">BUILDING CONSTRUCTION</option>
                                <option value="BUSINESS ADMIN - GENERAL">BUSINESS ADMIN - GENERAL</option>
                                <option value="CHEMICAL ENGINEERING">CHEMICAL ENGINEERING</option>
                                <option value="CHEMISTRY">CHEMISTRY</option>
                                <option value="CIVIL & COASTAL ENGINEERING">CIVIL & COASTAL ENGINEERING</option>
                                <option value="CLASSICS">CLASSICS</option>
                                <option value="CLASSICS-GREEK">CLASSICS-GREEK</option>
                                <option value="CLASSICS-LATIN">CLASSICS-LATIN</option>
                                <option value="CLINICAL & HEALTH PSYCHOLOGY">CLINICAL & HEALTH PSYCHOLOGY</option>
                                <option value="COMPUTER & INFO SCI & ENGINEER">COMPUTER & INFO SCI & ENGINEER</option>
                                <option value="CORRESPONDENCE STUDY">CORRESPONDENCE STUDY</option>
                                <option value="DENTISTRY-ORAL DIAG SCIENCES">DENTISTRY-ORAL DIAG SCIENCES</option>
                                <option value="DESIGN CONSTRUCTION AND PLANNING">DESIGN CONSTRUCTION AND PLANNING</option>
                                <option value="DIGITAL WORLDS INSTITUTE">DIGITAL WORLDS INSTITUTE</option>
                                <option value="ECONOMICS">ECONOMICS</option>
                                <option value="EDUCATION-HUM DEV & ORG STUDIES">EDUCATION-HUM DEV & ORG STUDIES</option>
                                <option value="EDUCATION-SP ED/SCH PSYC/EARLY CH">EDUCATION-SP ED/SCH PSYC/EARLY CH</option>
                                <option value="EDUCATION-TEACHING AND LEARNING">EDUCATION-TEACHING AND LEARNING</option>
                                <option value="ELECTRICAL & COMPUTER ENGINEERING">ELECTRICAL & COMPUTER ENGINEERING</option>
                                <option value="ENGINEERING - GENERAL">ENGINEERING - GENERAL</option>
                                <option value="ENGLISH">ENGLISH</option>
                                <option value="ENTOMOLOGY & NEMATOLOGY">ENTOMOLOGY & NEMATOLOGY</option>
                                <option value="ENVIRONMENTAL & GLOBAL HEALTH">ENVIRONMENTAL & GLOBAL HEALTH</option>
                                <option value="ENVIRONMENTAL ENGINEERING SCIENCE">ENVIRONMENTAL ENGINEERING SCIENCE</option>
                                <option value="ENVIRONMENTAL HORTICULTURE">ENVIRONMENTAL HORTICULTURE</option>
                                <option value="EPIDEMIOLOGY">EPIDEMIOLOGY</option>
                                <option value="EUROPEAN STUDIES">EUROPEAN STUDIES</option>
                                <option value="FAMILY YOUTH & COMMUNITY SCIENCES">FAMILY YOUTH & COMMUNITY SCIENCES</option>
                                <option value="FINANCE, INSURANCE & REAL ESTATE">FINANCE, INSURANCE & REAL ESTATE</option>
                                <option value="FINE ARTS">FINE ARTS</option>
                                <option value="FIRST YEAR FLORIDA">FIRST YEAR FLORIDA</option>
                                <option value="FISHERIES & AQUATIC SCIEN-SFRC">FISHERIES & AQUATIC SCIEN-SFRC</option>
                                <option value="FOOD & RESOURCE ECONOMICS">FOOD & RESOURCE ECONOMICS</option>
                                <option value="FOOD SCIENCE & HUMAN NUTRITION">FOOD SCIENCE & HUMAN NUTRITION</option>
                                <option value="FOREST RESOURCES & CONSER-SFRC">FOREST RESOURCES & CONSER-SFRC</option>
                                <option value="GEOGRAPHY">GEOGRAPHY</option>
                                <option value="GEOMATICS-SFRC">GEOMATICS-SFRC</option>
                                <option value="GEOLOGICAL SCIENCES">GEOLOGICAL SCIENCES</option>
                                <option value="HEALTH EDUCATION & BEHAVIOR">HEALTH EDUCATION & BEHAVIOR</option>
                                <option value="HEALTH OUTCOMES & POLICY">HEALTH OUTCOMES & POLICY</option>
                                <option value="HEALTH PROFESSIONS">HEALTH PROFESSIONS</option>
                                <option value="HEALTH SERVICES ADMINISTRATION">HEALTH SERVICES ADMINISTRATION</option>
                                <option value="HISTORY">HISTORY</option>
                                <option value="HONORS PROGRAM">HONORS PROGRAM</option>
                                <option value="HORTICULTURAL SCIENCES">HORTICULTURAL SCIENCES</option>
                                <option value="INDUSTRIAL & SYSTEMS ENGINEERING<">INDUSTRIAL & SYSTEMS ENGINEERING</option>
                                <option value="INFORMATION SYS & OPERATIONS MGT">INFORMATION SYS & OPERATIONS MGT</option>
                                <option value="INNOVATION ACADEMY">INNOVATION ACADEMY</option>
                                <option value="INTERDISCIPLINARY STUDIES">INTERDISCIPLINARY STUDIES</option>
                                <option value="INTERIOR DESIGN">INTERIOR DESIGN</option>
                                <option value="JEWISH STUDIES">JEWISH STUDIES</option>
                                <option value="JOURNALISM">JOURNALISM</option>
                                <option value="LANDSCAPE ARCHITECTURE">LANDSCAPE ARCHITECTURE</option>
                                <option value="LANGUAGES LIT/CULTURE">LANGUAGES LIT/CULTURE</option>
                                <option value="LANGUAGES LIT/CULTURE-AKAN">LANGUAGES LIT/CULTURE-AKAN</option>
                                <option value="LANGUAGES LIT/CULTURE-AMHARIC">LANGUAGES LIT/CULTURE-AMHARIC</option>
                                <option value="LANGUAGES LIT/CULTURE-ARABIC">LANGUAGES LIT/CULTURE-ARABIC</option>
                                <option value="LANGUAGES LIT/CULTURE-CHINESE">LANGUAGES LIT/CULTURE-CHINESE</option>
                                <option value="LANGUAGES LIT/CULTURE-CZECH">LANGUAGES LIT/CULTURE-CZECH</option>
                                <option value="LANGUAGES LIT/CULTURE-DUTCH">LANGUAGES LIT/CULTURE-DUTCH</option>
                                <option value="LANGUAGES LIT/CULTURE-FRENCH">LANGUAGES LIT/CULTURE-FRENCH</option>
                                <option value="LANGUAGES LIT/CULTURE-GERMAN">LANGUAGES LIT/CULTURE-GERMAN</option>
                                <option value="LANGUAGES LIT/CULTURE-HAITIAN/CRE">LANGUAGES LIT/CULTURE-HAITIAN/CRE</option>
                                <option value="LANGUAGES LIT/CULTURE-HEBREW">LANGUAGES LIT/CULTURE-HEBREW</option>
                                <option value="LANGUAGES LIT/CULTURE-ITALIAN">LANGUAGES LIT/CULTURE-ITALIAN</option>
                                <option value="LANGUAGES LIT/CULTURE-JAPANESE<">LANGUAGES LIT/CULTURE-JAPANESE</option>
                                <option value="LANGUAGES LIT/CULTURE-POLISH">LANGUAGES LIT/CULTURE-POLISH</option>
                                <option value="LANGUAGES LIT/CULTURE-RUSSIAN">LANGUAGES LIT/CULTURE-RUSSIAN</option>
                                <option value="LANGUAGES LIT/CULTURE-SWAHILI">LANGUAGES LIT/CULTURE-SWAHILI</option>
                                <option value="LANGUAGES LIT/CULTURE-VIETNAMESE">LANGUAGES LIT/CULTURE-VIETNAMESE</option>
                                <option value="LANGUAGES LIT/CULTURE-WOLOF">LANGUAGES LIT/CULTURE-WOLOF</option>
                                <option value="LANGUAGES LIT/CULTURE-YORUBA">LANGUAGES LIT/CULTURE-YORUBA</option>
                                <option value="LATIN AMERICAN STUDIES">LATIN AMERICAN STUDIES</option>
                                <option value="LAW">LAW</option>
                                <option value="LAW - TAXATION">LAW - TAXATION</option>
                                <option value="LINGUISTICS">LINGUISTICS</option>
                                <option value="MANAGEMENT">MANAGEMENT</option>
                                <option value="MARKETING">MARKETING</option>
                                <option value="MASS COMMUNICATION">MASS COMMUNICATION</option>
                                <option value="MATERIALS SCIENCE & ENGINEERING">MATERIALS SCIENCE & ENGINEERING</option>
                                <option value="MATHEMATICS">MATHEMATICS</option>
                                <option value="MECHANICAL/AEROSPACE ENGINEERING">MECHANICAL/AEROSPACE ENGINEERING</option>
                                <option value="MEDICINE">MEDICINE</option>
                                <option value="MEDICINE-ANATOMY">MEDICINE-ANATOMY</option>
                                <option value="MEDICINE-ANESTHESIOLOGY">MEDICINE-ANESTHESIOLOGY</option>
                                <option value="MEDICINE-BIOCHEMISTRY">MEDICINE-BIOCHEMISTRY</option>
                                <option value="MEDICINE-COMMUNITY HLTH/FAMILY MD">MEDICINE-COMMUNITY HLTH/FAMILY MD</option>
                                <option value="MEDICINE-EMERGENCY MEDICINE">MEDICINE-EMERGENCY MEDICINE</option>
                                <option value="MEDICINE-GENERAL">MEDICINE-GENERAL</option>
                                <option value="MEDICINE-MOLEC GENETICS/MICROBIOL">MEDICINE-MOLEC GENETICS/MICROBIOL</option>
                                <option value="MEDICINE-NEUROLOGY">MEDICINE-NEUROLOGY</option>
                                <option value="MEDICINE-NEUROSCIENCE">MEDICINE-NEUROSCIENCE</option>
                                <option value="MEDICINE-NEUROSURGERY">MEDICINE-NEUROSURGERY</option>
                                <option value="MEDICINE-OBSTETRICS/GYNECOLOGY">MEDICINE-OBSTETRICS/GYNECOLOGY</option>
                                <option value="MEDICINE-OPHTHALMOLOGY">MEDICINE-OPHTHALMOLOGY</option>
                                <option value="MEDICINE-ORTHOPAEDICS & REHAB">MEDICINE-ORTHOPAEDICS & REHAB</option>
                                <option value="MEDICINE-OTOLARYNGOLOGY">MEDICINE-OTOLARYNGOLOGY</option>
                                <option value="MEDICINE-PATHOL,IMMUNOL & LAB MED">MEDICINE-PATHOL,IMMUNOL & LAB MED</option>
                                <option value="MEDICINE-PEDIATRICS">MEDICINE-PEDIATRICS</option>
                                <option value="MEDICINE-PHARMACOLOGY">MEDICINE-PHARMACOLOGY</option>
                                <option value="MEDICINE-PHYSICIAN ASSISTANT">MEDICINE-PHYSICIAN ASSISTANT</option>
                                <option value="MEDICINE-PHYSIOLOGY">MEDICINE-PHYSIOLOGY</option>
                                <option value="MEDICINE-PSYCHIATRY">MEDICINE-PSYCHIATRY</option>
                                <option value="MEDICINE-RADIOLOGY">MEDICINE-RADIOLOGY</option>
                                <option value="MEDICINE-RADIATION ONCOLOGY">MEDICINE-RADIATION ONCOLOGY</option>
                                <option value="MEDICINE-SURGERY">MEDICINE-SURGERY</option>
                                <option value="MEDIEVAL & EARLY MODERN STUDIES">MEDIEVAL & EARLY MODERN STUDIES</option>
                                <option value="MICROBIOLOGY & CELL SCIENCE">MICROBIOLOGY & CELL SCIENCE</option>
                                <option value="MILITARY SCIENCE - AIR FORCE">MILITARY SCIENCE - AIR FORCE</option>
                                <option value="MILITARY SCIENCE - ARMY">MILITARY SCIENCE - ARMY</option>
                                <option value="MILITARY SCIENCE - NAVY">MILITARY SCIENCE - NAVY</option>
                                <option value="MUSIC">MUSIC</option>
                                <option value="NATURAL RESOURCES & ENVIRONMENT">NATURAL RESOURCES & ENVIRONMENT</option>
                                <option value="NUCLEAR & RADIOLOGICAL ENGINEER">NUCLEAR & RADIOLOGICAL ENGINEER</option>
                                <option value="NURSING-ADULT & ELDERLY NURSING">NURSING-ADULT & ELDERLY NURSING</option>
                                <option value="NURSING-HEALTH CARE ENV/SYSTEMS">NURSING-HEALTH CARE ENV/SYSTEMS</option>
                                <option value="NURSING-WOMEN, CHILDREN & FAMILY">NURSING-WOMEN, CHILDREN & FAMILY</option>
                                <option value="OCCUPATIONAL THERAPY">OCCUPATIONAL THERAPY</option>
                                <option value="PACKAGING SCIENCES">PACKAGING SCIENCES</option>
                                <option value="PHA-MEDICINAL CHEMISTRY">PHA-MEDICINAL CHEMISTRY</option>
                                <option value="PHA-PHARMACEUTICAL OUTCOME/POLICY">PHA-PHARMACEUTICAL OUTCOME/POLICY</option>
                                <option value="PHA-PHARMACEUTICS">PHA-PHARMACEUTICS</option>
                                <option value="PHA-PHARMACODYNAMICS">PHA-PHARMACODYNAMICS</option>
                                <option value="PHA-PHARMACOTHRPY/TRANSLTNL RSRCH">PHA-PHARMACOTHRPY/TRANSLTNL RSRCH</option>
                                <option value="PHILOSOPHY">PHILOSOPHY</option>
                                <option value="PHYSICAL THERAPY">PHYSICAL THERAPY</option>
                                <option value="PHYSICS">PHYSICS</option>
                                <option value="PLANT PATHOLOGY">PLANT PATHOLOGY</option>
                                <option value="POLITICAL SCIENCE">POLITICAL SCIENCE</option>
                                <option value="PSYCHOLOGY">PSYCHOLOGY</option>
                                <option value="PUBLIC HEALTH">PUBLIC HEALTH</option>
                                <option value="PUBLIC RELATIONS">PUBLIC RELATIONS</option>
                                <option value="REHABILITATION SCIENCE">REHABILITATION SCIENCE</option>
                                <option value="RELIGION">RELIGION</option>
                                <option value="SOCIOLOGY/CRIMINOLOGY/LAW-CRIMINO">SOCIOLOGY/CRIMINOLOGY/LAW-CRIMINO</option>
                                <option value="SOCIOLOGY/CRIMINOLOGY/LAW-SOCIOLO">SOCIOLOGY/CRIMINOLOGY/LAW-SOCIOLO</option>
                                <option value="SOIL AND WATER SCIENCE">SOIL AND WATER SCIENCE</option>
                                <option value="SPANISH/PORTUGUESE STUDIES-PORTUG">SPANISH/PORTUGUESE STUDIES-PORTUG</option>
                                <option value="SPANISH/PORTUGUESE STUDIES-SPANIS">SPANISH/PORTUGUESE STUDIES-SPANIS</option>
                                <option value="SPEECH, LANGUAGE, & HEARING SCI.">SPEECH, LANGUAGE, & HEARING SCI.</option>
                                <option value="STATISTICS-CALS">STATISTICS-CALS</option>
                                <option value="STATISTICS">STATISTICS</option>
                                <option value="TELECOMMUNICATION">TELECOMMUNICATION</option>
                                <option value="THEATRE AND DANCE">THEATRE AND DANCE</option>
                                <option value="TOURISM RECREATION SP MANAGEMENT">TOURISM RECREATION SP MANAGEMENT</option>
                                <option value="URBAN & REGIONAL PLANNING">URBAN & REGIONAL PLANNING</option>
                                <option value="VETERINARY MEDICAL SCIENCES">VETERINARY MEDICAL SCIENCES</option>
                                <option value=">WILDLIFE ECOLOGY & CONSERVATION">WILDLIFE ECOLOGY & CONSERVATION</option>
                                <option value="WOMEN'S STUDIES">WOMEN'S STUDIES</option>
                                <option value="WRITING PROGRAM">WRITING PROGRAM</option>
                                <option value="WRITTEN & ORAL COMMUNICATION">WRITTEN & ORAL COMMUNICATION</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<!--<script src = "<?php echo base_url();?>assets/js/bootstrap-checkbox.js"></script>
<script>
$('.checkbox').checkbox();
</script>-->
</html>
