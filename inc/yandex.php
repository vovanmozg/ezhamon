<?
function yandexGetPagesCount($url){

	//$file=implode("",file("http://www.yandex.ru/yandsearch?numdoc=10&text=%23url%3D%22$url*%22&pag=d&rd=0"));
	if($_GET["debug"] == "7") {echo "http://www.yandex.ru/yandsearch?date=&text=&spcctx=notfar&zone=all&wordforms=all&lang=all&within=0&from_day=&from_month=&from_year=&to_day=27&to_month=11&to_year=2007&mime=all&site=$url&rstr=&ds=&numdoc=10";}
	$file=implode("",file("http://www.yandex.ru/yandsearch?date=&text=&spcctx=notfar&zone=all&wordforms=all&lang=all&within=0&from_day=&from_month=&from_year=&to_day=27&to_month=11&to_year=2007&mime=all&site=$url&rstr=&ds=&numdoc=10"));

	if(preg_match("!\&mdash\; <b>([^<]*)</b>!si",$file,$ok)){ 
		$str=$ok[1];
		
	} 
	else {
		$str="x";
	}
	return $str;
}

function yandexGetReferencesCount($url){

	//$file=implode("",file("http://www.yandex.ru/yandsearch?numdoc=10&text=%23url%3D%22$url*%22&pag=d&rd=0"));
	if($_GET["debug"] == "7") {echo "http://www.yandex.ru/yandsearch?text=%22$url%22";}
	$file=implode("",file("http://www.yandex.ru/yandsearch?text=%22$url%22"));

	if(preg_match("!\&mdash\; <b>([^<]*)</b>!si",$file,$ok)){ 
		$str=$ok[1];
		
	} 
	else {
		$str="x";
	}
	return $str;
}

function yandexGetCY($url){
	$cy["95e4d55299c4f02e7c6ff2f2e1e344b1"] = 10;
	$cy["00f600cc6d07d829c520703410f0c690"] = 100;
	$cy["56a0d98426e3f1e5db3c255e7f3d3b88"] = 1000;
	$cy["0046bea26efffa18f9f64a2846564df6"] = 10000;
	$cy["2de254126c80f56842e69411b62cd637"] = 110;
	$cy["8d7d2ad9a533268e7331cfa3b6f2a9ca"] = 1100;
	$cy["5a82f265f17dfa8d238cce2daa04f241"] = 11000;
	$cy["871f7de2c82ff7f73aaca62be5f0c041"] = 120;
	$cy["ae58c9dc6d9655046c4e8d1207c7f6e3"] = 1200;
	$cy["7f97cb75dded24bd7218db48ad0e54c2"] = 12000;
	$cy["4bd087dfc3aac7aeb2eabb055f4c819d"] = 130;
	$cy["6e612a419e898fee0bad75c24dd3fde8"] = 1300;
	$cy["b87ba4ca71248aef7d34dc845f0e256a"] = 13000;
	$cy["1acb5d594f20c8afcc5b2fe281b1998e"] = 140;
	$cy["7a517b7d1a2db8704605956aaf27eac2"] = 1400;
	$cy["f9ed82b788e5ee66979aaad62ff8858d"] = 14000;
	$cy["b6957d268bf835c683504bf9acc20d16"] = 150;
	$cy["cc0566813e680434e375352bf795b0ed"] = 1500;
	$cy["d50318bd378ada030df44ab06fe4e5c4"] = 15000;
	$cy["bc9d69415ef4ab831d5b53556835e6be"] = 160;
	$cy["b6c99847de9427818da5eb2bd787a597"] = 1600;
	$cy["9f11bfe927037f03dff507b0291cb24f"] = 16000;
	$cy["a02e91b5a959066ca3a815610798fd2e"] = 170;
	$cy["98bc4b4a956c88f90189fdc618aaab63"] = 1700;
	$cy["6ca14547426f654b5daa813cf1b553cd"] = 17000;
	$cy["16ebf979c89e99c2e123905ea817efa2"] = 180;
	$cy["01f921f0941570e5ab8f4fbea4624040"] = 1800;
	$cy["166ef5024f305e501b9848c8d2b96566"] = 18000;
	$cy["a04d5da62c3c77505b189eb51de84466"] = 190;
	$cy["9b4751886dd947b927aa70640cd6024f"] = 1900;
	$cy["031d7ee57551cb44517b3fe62034c23f"] = 19000;
	$cy["a22288b6875ca5f1267e36a85da98e26"] = 20;
	$cy["2783447c1441914c2cbd0a93bcaa6b64"] = 200;
	$cy["a197093fc45125650019c706ad992620"] = 2000;
	$cy["e303b10c0b6ff42d68697dde2ae7f1c9"] = 210;
	$cy["5ee2ee60afa98576ef21811317cb0323"] = 2100;
	$cy["cae9ba5e29d7e0d40f6eadba8315067a"] = 21000;
	$cy["855c666a9ccee22faf3c4040e76a42d7"] = 220;
	$cy["6b78158dde07bba39227b2d038b00e37"] = 2200;
	$cy["b32218c84dcba5193a95571af9c6cddd"] = 230;
	$cy["b8c6fe17b2c4690260ee8a6d0626fa50"] = 2300;
	$cy["0fb160e6b7cd5ee37bc3b0093c5aa366"] = 240;
	$cy["f78ef4ff92e5335a69bcbab47524a54a"] = 2400;
	$cy["bfdbb90a891b177c1132355deb5e16f9"] = 24000;
	$cy["7b864a903ccc5590f88e74a2bb591d1f"] = 250;
	$cy["75d8123fcd4dad28ae5c252de9fb30c1"] = 2500;
	$cy["e868a78b4d65f0a7cc8b94b3c8ffbec0"] = 25000;
	$cy["932b0adc449b3800dfce3e645eeedfd2"] = 2600;
	$cy["996eb28f8854e6522743691c9fd26a33"] = 2700;
	$cy["d5b7a51d75621c70a8e9b70a86db5065"] = 275;
	$cy["7defd719542af3e72c0bd8328ca71739"] = 2800;
	$cy["9f6a6fc861659898b4db7e5d6ced6ccf"] = 2900;
	$cy["277813f310c72f7ca615ccf80ef9666e"] = 29000;
	$cy["06016ce6065e52b989adc477c4479b58"] = 30;
	$cy["1122c9b2b945b4663cf49fc7d2396e58"] = 300;
	$cy["21e4aedacb82ada53538330658cbd8e3"] = 3000;
	$cy["f0e572a81237b5c324fe9a296f9f2c21"] = 3100;
	$cy["32a48a18d448f0283b6158c6dfd6e4dd"] = 3200;
	$cy["1c2d057841f90b8e8c41d8afc52f1f43"] = 325;
	$cy["d6d6a3e1098564ae4cb3ab0d3e62effb"] = 3300;
	$cy["6331ffc37b89232338f5ad75a6c7c5ae"] = 3400;
	$cy["5bd5bedd8659e1a970bd14b50024587f"] = 350;
	$cy["6d3419bee874c5790d14f766d9f4070b"] = 3500;
	$cy["3f0dfcf4ca02e5a0f447cac64e5d60e1"] = 3600;
	$cy["f11907f4908517a11caa094095997672"] = 3700;
	$cy["f952493ff2f58ea902a17414bf9ccaf9"] = 375;
	$cy["ee4c35b10b3daddbaec0306d9c6e5775"] = 3800;
	$cy["76876e7fccd76beca16a5d961fb957a0"] = 3900;
	$cy["aac0d954c4963fe4107c2844583a4bad"] = 40;
	$cy["8bd2df5c376da15dba63bd822b3164d8"] = 400;
	$cy["b90e39f1bf9883b46a5c424bff6048d5"] = 4000;
	$cy["356feb78f5b946d3faadea38dfac17d5"] = 4100;
	$cy["2baaae0a77e41086c25b1be2ba592f47"] = 4200;
	$cy["eab511a533b09591699672e44e1eaf36"] = 425;
	$cy["740cc2b7f0ac74d19d5204142260bab5"] = 4300;
	$cy["d4d1b17b1265fc0db60bc2d2efc728d3"] = 4400;
	$cy["3331dcae6cd03cc89108556c5c95e8af"] = 450;
	$cy["867fdc44da7abb893b096015051f3d8f"] = 4500;
	$cy["22f4b0805c18923df8dec60690e9b44f"] = 4600;
	$cy["e447b913b83bb8bc1cd9572df5bdc9ac"] = 4700;
	$cy["40d743c8ad20d1852b918fe2d18acde3"] = 475;
	$cy["ff27474e3d9d7890f0a9945914e82dd3"] = 4800;
	$cy["0e015de80ca8819c6f278c02f6a3fd82"] = 4900;
	$cy["67216d6c7f5487f7f70e66294d653726"] = 50;
	$cy["2b2df17e5f68bb7dadf42da6e9e904c4"] = 500;
	$cy["58a7f84a2d70007535bf1813cd0b09be"] = 5000;
	$cy["a56500f982f52f142e10417a9081f7c4"] = 5100;
	$cy["73d7e31f03c316da890210687b61643a"] = 5200;
	$cy["3af25707afb45992d26cd6728546526d"] = 5300;
	$cy["f448acc2042755fded1ed5a206a637fd"] = 5400;
	$cy["25be78e1c9d24ad5b97a597ba31844cb"] = 550;
	$cy["a38494eb2606eb3b3a0d0e4d2f0b76c8"] = 5500;
	$cy["f2986d6279ad73b95148922bb88597fc"] = 5600;
	$cy["a47b61dae88fdaa7a2799178001c721b"] = 5700;
	$cy["58357249792698cf22d9e8bae8ce70c5"] = 5800;
	$cy["c539359c79a5cf3e4b91be2e21a85e6b"] = 5900;
	$cy["66fdb7ddeeaae9e099cdaeeefd9d6ced"] = 60;
	$cy["906890d7ae73ad199bcea0c414438d8d"] = 600;
	$cy["f0c36bfa908dc642f618084154c17266"] = 6000;
	$cy["c3eb90dbd3092d157313509f438eccf6"] = 6100;
	$cy["28a433fe357fcf6beac885d9e7148294"] = 6200;
	$cy["ed64e6ab72bc175be05b143bcea4f53f"] = 6300;
	$cy["85d243f8b84757967ed46349a279db03"] = 6400;
	$cy["ae783a0ba6495c4d2feb392034f5bc74"] = 650;
	$cy["63864e9844400546bb64d15f6cd9f96b"] = 6500;
	$cy["7a9ac8af9488db62436ea3ef6b3f8be1"] = 6600;
	$cy["b5cbebc03a885a5a5d31f7faf959965e"] = 6700;
	$cy["4154084ea7a0847e63dd2e55df551187"] = 6800;
	$cy["ae282064e3de2d85e3ff16f4b99f9378"] = 6900;
	$cy["423cdca1beff94b0ff1dd1ded1a21f13"] = 70;
	$cy["b4e4a20443dbcff234fbc64e2f677f2b"] = 700;
	$cy["334db01b08e410e23e63594a6c669d71"] = 7000;
	$cy["001da1cf2f9eec9e44390cbe5c3c43bf"] = 7100;
	$cy["c4f2cad25413bebc3f0151cd1b0f300a"] = 7200;
	$cy["613740151695a9bf4c3834d61880e1d3"] = 7300;
	$cy["1356add303796dea8700339a02111d32"] = 7400;
	$cy["a06fe5861ac100fef15d22b5503a9008"] = 750;
	$cy["137e19302b1d60b496b020f25cc171f8"] = 7500;
	$cy["8f8f012d3febbf8f9c8ad2ebc4bf113e"] = 7600;
	$cy["2f7d3e56ea1eb2f47d1ea98091b5ede6"] = 7700;
	$cy["c33875029ec827f367b64afb15538481"] = 7800;
	$cy["82263c0b6c5db6c65f398730eb9c3023"] = 7900;
	$cy["338484898961ee16997a41bced571899"] = 80;
	$cy["2a9c11a68a5a27a39edfbf5706a1fea6"] = 800;
	$cy["a73a4ae6dfd53e232282db37e2cb77bb"] = 8000;
	$cy["61a1608ee06c17f3e10c80bb2af89660"] = 8100;
	$cy["c6b255a9482dc7713ee05d7df76da288"] = 8200;
	$cy["9005f35ec940aa746c3148b812c6cfba"] = 8300;
	$cy["9cf8263e965b96873a663e159580bcf5"] = 8400;
	$cy["a43a1bc09e8364a3d8e22604ad5f2f14"] = 850;
	$cy["b4b0f8cdae41e64df615f847357153ed"] = 8500;
	$cy["74c99326c444371ce4e4f206af3435d1"] = 8600;
	$cy["d0686a7c3a2caa84dacae1fb3b33b830"] = 8800;
	$cy["6a306e0fff6be664c4fa1b9d12e95636"] = 90;
	$cy["eddd9a0baee6414f2d4bb88374b326d1"] = 900;
	$cy["6aa9d0eb3e9afcb4bd9df36c7b3472f2"] = 9100;
	$cy["d839a8e6694a1b27fa51844e60fa14db"] = 9200;
	$cy["b25f9bfe0d5a9541990a85c98f24c13d"] = 9300;
	$cy["f1db7f08b3707a729ff85acc142832bc"] = 9400;
	$cy["2758c2fe2078e104c8fa1f6ebfd3c709"] = 950;
	$cy["9e134ed2f671e734f0fe1417ee1a92fc"] = 9600;
	$cy["54eb44c60518bf903bd030a1c0dc1592"] = 9700;
	$cy["b37e28cb407dca49697e2cc4d0235ccc"] = 9800;
	$cy["8b38a61b5f9bddf0cebc449f570a134d"] = 9900;
	$cy["4289557bfdc1e7231157598a9a1b8548"] = "0";
	$cy["d41d8cd98f00b204e9800998ecf8427e"] = "0";

	$cybutton=implode("",file("http://www.yandex.ru/cycounter?$url"));
	$hash = md5($cybutton);
	if(array_key_exists($hash,$cy)){
		return $cy[$hash];
	}
	return "x";
}
?>