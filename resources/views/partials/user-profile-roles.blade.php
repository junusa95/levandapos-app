
<?php 

    if ($user->roles()->get()->isNotEmpty()) {
        foreach($user->roles()->get() as $role) { ?>
        	<span style="display: block;font-weight: bold;"> 
        		{{$role->name}}..  
        		<?php 
        			if ($role->name == "Cashier") {
        				$shops = DB::table('user_shops')->where('user_id',$user->id)->where('who','cashier')->get();
		                if ($shops->isNotEmpty()) {
		                	echo "<span style='font-weight:normal'>(";
		                    foreach($shops as $shop) {
		                        $sname = App\Shop::where('id',$shop->shop_id)->where('company_id',Auth::user()->company_id)->first();
		                        echo $sname->name.", ";
		                    }
		                    echo ")</span>";
		                }
        			}
        		?> 
        		<?php 
        			if ($role->name == "Sales Person") {
        				$shops = DB::table('user_shops')->where('user_id',$user->id)->where('who','sale person')->get();
		                if ($shops->isNotEmpty()) {
		                	echo "<span style='font-weight:normal'>(";
		                    foreach($shops as $shop) {
		                        $sname = App\Shop::where('id',$shop->shop_id)->where('company_id',Auth::user()->company_id)->first();
		                        echo $sname->name.", ";
		                    }
		                    echo ")</span>";
		                }
        			}
        		?> 
        		<?php 
        			if ($role->name == "Store Master") {
        				$stores = DB::table('user_stores')->where('user_id',$user->id)->where('who','store master')->get();
		                if ($stores->isNotEmpty()) {
		                	echo "<span style='font-weight:normal'>(";
		                    foreach($stores as $store) {
		                        $sname = App\Store::where('id',$store->store_id)->where('company_id',Auth::user()->company_id)->first();
		                        echo $sname->name.", ";
		                    }
		                    echo ")</span>";
		                }
        			}
        		?>
        	</span>
        	<?php
        }
    }

 ?>