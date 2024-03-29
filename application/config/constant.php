<?php

/**
 * 
  * @desc		: Constant Class
  * @creator	: BrianC
  * @date		: 2019. 8. 19.
  * @Version	: 
  * @history	: 
  *
 */
class ConstClass 
{
	// 권한 테스트
	private const admin = 'R0001,R0002,R0003,R0004,R0005,R0006,R0007,R0008,R0009,R0010,R0011,R0012,R0013,R0014,R0015,R0016,R0017,R0018,R0019,R0020,R0021';
	private const van_cq_staff = 'R0018,R0020,R0005,R0011';
	
	function getRsrcListByRoleId ($roleId)
	{
		if($roleId == 'admin') {
			return self::admin;
		} else if ($roleId == 'van_cq_staff') {
			return self::van_cq_staff;
		}
	}
	
	const RSA_PRIVATE_KEY = '-----BEGIN PRIVATE KEY-----
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 jnE2JVcmx25UUIMahNZRXrqXrmk556g=
-----END PRIVATE KEY-----';

	function getRsaPrivKey ()
	{
		return self::RSA_PRIVATE_KEY;
	}
	
	
}