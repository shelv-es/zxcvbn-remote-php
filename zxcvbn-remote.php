<?
class ZxcvbnRemote {
	private $endpoint;

	function ZxcvbnRemote($endpoint) {
		$this->endpoint = $endpoint;
	}

	function zxcvbn($password) {
		$curl = curl_init($this->endpoint . '/zxcvbn');
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('password' => $password)));

		$response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$error = curl_error($curl);
		$errno = curl_errno($curl);

		curl_close($curl);

		if($status != 200) {
			throw new Exception("ZxcvbnRemote: $status [$errno] $error");
		} else {
			return json_decode($response, true);
		}
	}
}

