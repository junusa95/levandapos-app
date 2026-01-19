
                                    <div class="col-md-12 mt-3" style="text-align:right">
                                        <h5>
                                            <?php 
                                                if (isset($data['shop'])) { 
                                                    echo $data['shop']->name; 
                                                    $shopstore = "shop";
                                                    $id = $data['shop']->id;
                                                }
                                                if (isset($data['store'])) { 
                                                    echo $data['store']->name; 
                                                    $shopstore = "store";
                                                    $id = $data['store']->id;
                                                }
                                            ?> 
                                        </h5>
                                        <p>Total Quantities Available: <span class="bg-dark text-light px-2 py-1 ml-2 totalSQ">{{$data['quantity']}}</span></p>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="body xl-khaki">
                                            <p class="time">Today</p> 
                                            <div class="row text-center">
                                                <div class="col-6">    
                                                    <h4>{{$data['addedT']}}</h4>
                                                    <span>Added</span>
                                                </div>
                                                <div class="col-6">    
                                                    <h4>{{$data['reducedT']}}</h4>
                                                    <span>Reduced</span>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="body xl-blue">
                                            <p class="time">This week</p>   
                                            <div class="row text-center">
                                                <div class="col-6">    
                                                    <h4>{{$data['addedW']}}</h4>
                                                    <span>Added</span>
                                                </div>
                                                <div class="col-6">    
                                                    <h4>{{$data['reducedW']}}</h4>
                                                    <span>Reduced</span>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="body xl-turquoise">
                                            <p class="time">This month</p>
                                            <div class="row text-center">
                                                <div class="col-6">    
                                                    <h4>{{$data['addedM']}}</h4>
                                                    <span>Added</span>
                                                </div>
                                                <div class="col-6">    
                                                    <h4>{{$data['reducedM']}}</h4>
                                                    <span>Reduced</span>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>

                                <div class="col-md-12 mt-3 mb-4" align="right">
                                    <a href="/business-owner/report/stock?shopstore=<?php echo $shopstore.'-'.$id; ?>" class="btn btn-primary btn-sm">View in Details</a>
                                </div>