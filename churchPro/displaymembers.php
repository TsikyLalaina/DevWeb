<?php
                        $query = "select * from members";
                        $result = mysqli_query($con, $query);
                        if($result){
                            if($result && mysqli_num_rows($result) > 0){
                                while($member_data = mysqli_fetch_assoc($result)){
                                    echo '<div class="column">
                                            <input type="checkbox" class="select-card" data-memberid="' . $member_data['studentid'] . '">
                                            <div class="imgBox">
                                                <img src="' . $member_data['image'] . '" alt="profile">
                                            </div>
                                            <div class="details">
                                                <h3>' . $member_data['fname'] . '<br><span>' . $member_data['position'] . '</span></h3>
                                                <ul>
                                                    <li><a href="' . $member_data['facebook'] . '" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                                    <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                                    <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                                                    <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>';
                                }                                  
                            }else{echo '<h1>Aucun membre pour le moment</h1>';}
                        }else{
                            echo "<h1>Failed to fetch informations<h1>";
                        }
