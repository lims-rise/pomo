<div class="content-wrapper">
    <section class="content">
        <?php 
        $lab = $this->session->userdata('lab');
        if ($lab == 1) {
            $labname = "Indonesia";
        }
        else {
            $labname = "Fiji";
        }
        echo alert('alert-info', 'Welcome '.$this->session->userdata('full_name') . ' to the '. $labname .' LIMS data', 
        "<i class='fa fa-hand-o-left' aria-hidden='true'></i>" . ' To switch accounting data between countries lab, please select the laboratory accordingly on the left side panel');
        
        ?>
    <div class="content" style="color: #252525;">
						<font size="3">
        <p style="text-align:justify"><span style="color:#000000;">
        Laboratory Information Management System (LIMS) is a software-based solution with features that support a modern laboratory's operations. Key features include—but are not limited to—workflow and data tracking support, flexible architecture, and data exchange interfaces, which fully "support its use in regulated environments". The features and uses of a LIMS have evolved over the years from simple sample tracking to an enterprise resource planning tool that manages multiple aspects of laboratory informatics.
        </span></p>
        <p style="text-align:justify"><span style="color:#000000;">
        Historically the LIMS, LIS, and process development execution system (PDES) have all performed similar functions. The term "LIMS" has tended to refer to informatics systems targeted for environmental, research, or commercial analysis such as pharmaceutical or petrochemical work. "LIS" has tended to refer to laboratory informatics systems in the forensics and clinical markets, which often required special case management tools.
        </span></p>
        <p style="text-align:justify"><span style="color:#000000;">
        In recent times LIMS functionality has spread even farther beyond its original purpose of sample management. Assay data management, data mining, data analysis, and electronic laboratory notebook (ELN) integration have been added to many LIMS, enabling the realization of translational medicine completely within a single software solution. Additionally, the distinction between LIMS and LIS has blurred, as many LIMS now also fully support comprehensive case-centric clinical data.
        </span></p>
        <p style="text-align:justify"><span style="color:#000000;">

        This LIMS application aims to support RISE laboratory activities in two countries (Indonesia & Fiji) and also support reports for all related researchers.
        </span></p>
						<!-- <p style="text-align:justify"><span style="color:#000000;">Hopefully this page is usefull for you</span></p>
					 -->
						</font>
                        <div style="text-align: right">
        <!-- <img src="../img/small.png" height="100px"/> -->
    </div>
    </div>
    </section>
</div>