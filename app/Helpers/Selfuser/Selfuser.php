<?php
	
	namespace App\Helpers\Selfuser;
	use Illuminate\Support\Facades\DB;
	use App\Sellerrole;
	use App\Role;
	class Selfuser {
			
		static public function revertRTL($text){
			preg_match_all('/./us', $text, $ar);
			 
			for($i = 0; $i <  count($ar[0]); $i++){
				if($ar[0][$i] == ')'){
					$ar[0][$i] = '(';  
					continue;
				}
				if($ar[0][$i] == '(') $ar[0][$i] = ')';
			}
			 
			$text = join('',array_reverse($ar[0]));
			return $text;
		}
		
		static public function hasPermissionseller($user_id, $role_id){
			$user = DB::table('users')->where('id', $user_id)->first();
			if(isset($user->usertype)){
 
				if($user->usertype == '1')
					return 1;
				 
				if($user->usertype == '5')
				{
					$role = Sellerrole::where('user_id', $user_id)->first();
					 
					if(isset($role))
					{
						if(($role_id == 1) && $role->m_fuelstation) 
							return 1;
						
						if(($role_id == 2) && $role->m_report)
							return 1;
						
						if(($role_id == 3) && $role->m_coupon)
							return 1;
						if(($role_id == 4) && $role->m_main)
							return 1;
					}
				}
			}
			return 0;
		}
		
		static public function hasPermissionadmin($user_id, $role_id){
			$user = DB::table('users')->where('id', $user_id)->first();
			if(isset($user->usertype)){
				if($user->usertype == '2')
					return 1;
				
				if($user->usertype == '6') // is admin
				{
					$role = Role::where('user_id', $user_id)->first();
					if(isset($role))
					{
					 
						if(($role_id == 1) && $role->m_user) 
							return 1;
						
						if(($role_id == 2) && $role->m_pay)
							return 1;
						
						if(($role_id == 3) && $role->m_fee)
							return 1;
						
						if(($role_id == 4) && $role->m_dep) 
							return 1;
						
						if(($role_id == 5) && $role->m_cup)
							return 1;
						
						if(($role_id == 6) && $role->m_wir)
							return 1;
						
						if(($role_id == 7) && $role->m_not) 
							return 1;
						
						if(($role_id == 8) && $role->m_mes) 
							return 1;
						
						if(($role_id == 9) && $role->m_rep) 
							return 1;
						
						if(($role_id == 10) && $role->m_gtc) 
							return 1;
						
						if(($role_id == 11) && $role->m_sub) 
							return 1;
						
						if(($role_id == 12) && $role->m_atd) 
							return 1;
						
						if(($role_id == 13) && $role->m_main) 
							return 1;
						if(($role_id == 14) && $role->m_map)
							return 1;
						if(($role_id == 15) && $role->m_qrs)
							return 1;

						if(($role_id == 16) && $role->m_vrc)
							return 1;
						
						if(($role_id == 17) && $role->m_udr)
							return 1;
					}
				}
			}
			return 0;
		}

		static public function hasPermissionByUrlAdmin($user_id, $url){
			$user = DB::table('users')->where('id', $user_id)->first();
			if(isset($user)){
				if($user->usertype == '2') return 1;
				 

				if($user->usertype == '6'){
					$role = Role::where('user_id', $user_id)->first();
 
					if(isset($role))
					{
						 

						//$url = $request->url();
						if(strpos($url, '/admin/fuelstation') !== false){
							if($role->m_user) return 1;
							else 	 return 0;
						}else if(strpos($url, '/admin/paymentmanager') !== false){
							if($role->m_pay)
								return 1;
							else return 0;
						}else if(strpos($url, '/admin/feesmanagement/feesmanagement') !== false){
							if( $role->m_fee) return 1;
							else 				 return 0;
						} else if(strpos($url, '/admin/depositmanagement') !== false){
							if($role->m_dep) return 1;
							else              return 0;
						}else if(strpos($url, '/admin/coupons') !== false){
							if($role->m_cup) return 1;
							else              return 0;
						}else if(strpos($url, '/admin/withdrawmanagement') !== false){
							if($role->m_wir) return 1;
							else              return 0;
						}else if(strpos($url, '/admin/messsages') !== false){
							if($role->m_mes) return 1;
							else              return 0;
						}else if(strpos($url, '/admin/reports') !== false){
							if($role->m_rep) return 1;
							else              return 0;
						}else if(strpos($url, '/admin/getintouch') !== false){
							if($role->m_gtc) return 1;
							else              return 0;
						}else if(strpos($url, '/admin/feesmanagement/subscription') !== false){
						 
							if($role->m_sub)  return 1;
							else              return 0;


						}else if(strpos($url, '/admin/attendances') !== false){
							if($role->m_atd) return 1;
							else              return 0;
						}else if(strpos($url, '/admin/home') !== false){
							if($role->m_main) return 1;
							else              return 0;
						}else if(strpos($url, '/admin/map') !== false){
							if($role->m_map) return 1;
							else              return 0;
						}
						else if(strpos($url, '/admin/qrstatus') !== false){
							if($role->m_map)  return 1;
							else              return 0;
						}
						else if(strpos($url, '/admin/vouchers') !== false){
							if($role->m_vrc)  return 1;
							else              return 0;
						}
						else if(strpos($url, '/admin/admindeposit') !== false){
							if($role->m_udr)  return 1;
							else              return 0;
						}
						else{
							return 1;
						}

					}
				}
			}
			return 0;
		}



		static public function hasPermissionByUrl($user_id, $url){
			$user = DB::table('users')->where('id', $user_id)->first();
			if(isset($user)){
				if($user->usertype == '1') return 1;
				$role = Sellerrole::where('user_id', $user_id)->first();

				if($user->usertype == '5'){
					$role = Sellerrole::where('user_id', $user_id)->first();
					if(isset($role))
					{
						//$url = $request->url();
						if(strpos($url, '/seller/fuelstation') !== false){
							if($role->m_fuelstation) return 1;
							else 					 return 0;
						}else if(strpos($url, '/seller/reports') !== false){
							if($role->m_report)
								return 1;
							else return 0;
						}else if(strpos($url, '/seller/coupons') !== false){
							if( $role->m_coupon) return 1;
							else 				 return 0;
						} else if(strpos($url, '/seller/home') !== false){
							if($role->m_main) return 1;
							else              return 0;
						}
						else{
							return 1;
						}

					}
				}
			}
			return 0;
		}
		
	}
