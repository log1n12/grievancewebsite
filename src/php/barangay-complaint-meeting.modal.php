<!-- MODAL OPEN MEETING (COMPLETE TABLE) -->
<div class="modal fade bd-example-modal-xl" id="meetingModal<?php echo $complaintRefNo ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content p-4">
            <div class="modal-header text-left">
                <div>
                    <h4 class="modal-title" id="myModalLabel">View Schedule</h4>
                    <p><span style="font-size: 13px; font-weight: 300;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, aspernatur odit<span></p>
                </div>


                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body mx-5">
                <h5 class="text-capitalize text-center"><i class="fas fa-info-circle fa-2x mr-2" style=" color: #111580;"></i>Brief information</h5>
                <hr>
                <p class="mt-3 mb-2"><span class="font-weight-bold">Reference Number:</span> <?php echo $complaintRefNo ?></p>
                <div class="complaintDiv mt-4">
                    <h6 class="font-weight-bolder mb-3">Meetings</h6>
                    <table class="table table-stripped table-responsive-sm">
                        <thead>
                            <tr>
                                <th class="text-center">Meeting ID</th>
                                <th class="text-center">Meeting No.</th>
                                <th class="text-center">Date of meeting</th>
                                <th class="text-center">Scheduled Time</th>
                                <th class="text-center">Time Ended</th>
                                <th class="text-center">Remarks</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Minutes of the meeting</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $getMeeting1 = "SELECT * FROM meeting WHERE case_ref_no = '$complaintRefNo'";
                            $getMeetingQuery1 = $con->query($getMeeting1);
                            $getMeetingQuery1->execute();

                            $getMeetingCount1 = $getMeetingQuery1->rowCount();

                            if ($getMeetingCount1 > 0) {
                                foreach ($getMeetingQuery1 as $row) {
                                    $meetingId = $row['id'];
                                    $meetingNumber = $row['meeting_no'];
                                    $meetingDate = $row['meet_date'];
                                    $meetingTime = $row['time_start'];
                                    $meetingRemarks = $row['remarks'];
                                    $meetingTimeEnded = $row['time_ended'];
                                    $meetingStatus = $row['meet_status'];
                                    $meetingMinutes = $row['meet_minutes'];
                            ?>

                                    <tr>
                                        <td><?php echo $meetingId; ?></td>
                                        <td style="display: none;"><?php echo $complaintRefNo; ?></td>
                                        <td>Meeting <?php echo $meetingNumber; ?></td>
                                        <td><?php
                                            $date1 = DateTime::createFromFormat('Y-m-d', $meetingDate);
                                            $date11 = $date1->format('F j, Y');
                                            echo $date11;
                                            ?></td>
                                        <td><?php
                                            $time1 = DateTime::createFromFormat('H:i', $meetingTime);
                                            $time11 = $time1->format('g:i a');
                                            echo $time11;
                                            ?></td>
                                        <td><?php echo $meetingTimeEnded; ?></td>
                                        <td><?php echo $meetingRemarks; ?></td>
                                        <td><?php echo $meetingStatus; ?></td>
                                        <td>
                                            <?php
                                            if ($meetingMinutes == "--") {
                                                echo "--";
                                            } else {
                                            ?>
                                                <a href="../assets/minutes/<?php echo $meetingMinutes ?>" target="_blank">minutesofthemeeting.docs</a>

                                            <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                            <?php }
                            } else {
                                echo "<tr><td colspan='12'><h6>There is no meeting here. </h6></td></tr>";
                            }
                            ?>
                        </tbody>

                    </table>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btnAccept" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->