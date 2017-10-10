<?php
	
	namespace App\Helpers\Selfuser;
	use Illuminate\Support\Facades\DB;
	use App\Sellerrole;
	use App\Role;
	class Selfuser {
	
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
					 
					}
				}
			}
			return 0;
		}
		
	}
