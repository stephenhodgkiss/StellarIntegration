var AjaxInitial;
var AjaxNotifyConfig;

function authLogin () {

	$("#errormsg").text("");

	var username = $("#user").val();
	var password = $("#password").val();

	//console.log("username="+username+" password="+password);

	if (username == "" || password == "") {
		$("#errormsg").text("Please enter a username and password");
	} else if (username.length > 50) {
		$("#errormsg").text("Username error: max 50 characters");
	} else if (password.length > 128) {
		$("#errormsg").text("Password error: max 128 characters");
	} else {

		document.body.style.cursor = "progress";
		AjaxInitial = $.post("/validate_login.php", {
			username: username,
			password: password
		},
		function(response) {

			document.body.style.cursor = "default";

			if (response != "ok") {
				$("#errormsg").text(response);
			} else {
				window.location.href = '/dashboard.php';
			}

		})

	}

}

function getBalance (networkNumber) {

	$("#errormsg").text("Processing.....");
	$("#data_balances").text('');

	var pubkey = $("#pubkey").val();

	if (networkNumber == 1) {
		var network = "public"
	} else {
		var network = "testnet"
	}

	//console.log("pubkey="+pubkey);

	if (pubkey == "") {
		$("#errormsg").text("Please enter a Public Key");
	} else if (pubkey.length != 56) {
		$("#errormsg").text("Public Key must be 56 characters");
	} else {

		document.getElementById("main_body").style.cursor = "wait";

		var response = doBalances(network,pubkey);

		document.getElementById("main_body").style.cursor = "default";

	}

}

function doBalances (network,pubkey) {

	var pubKey1 = pubkey;

	if (network == "public") {
		var server = new StellarSdk.Server("https://horizon.stellar.org");
		var networkName = StellarSdk.Networks.PUBLIC;
	} else {
		var server = new StellarSdk.Server("https://horizon-testnet.stellar.org");
		var networkName = StellarSdk.Networks.TESTNET;
	}

	// console.log('network='+network+' networkName='+networkName)

	server
		.loadAccount(pubKey1)
		.catch(function (error) {
			if (error instanceof StellarSdk.NotFoundError) {
				throw new Error('The destination account does not exist!');
			} else throw new Error(error);
		})
		// If there was no error, load up-to-date information on your account.
		.then(function() {
			return server.loadAccount(pubKey1);
		})
		.then(function(sourceAccount) {

			var balData = '<table class="col-md-12 table-bordered" style="color:white; padding:5px 5px"><tr style="background-color:#62cb31; text-align:center"><td class="table-borders" style="padding:5px"><span style="font-size:14px">Asset</span></td><td class="table-borders" style="padding:5px"><span style="font-size:14px">Balance</span></td></tr>'

			// console.log('\nBalances for account: ' + pubKey1)
			sourceAccount.balances.forEach((balance) => {
				var assetCode = balance.asset_code
				if (assetCode == undefined) { assetCode = "XLM" }
				// console.log('Asset:'+assetCode+', Balance:'+balance.balance)
				balData = balData+'<tr style="text-align:center">'
				balData = balData+'<td class="table-borders" style="padding:5px"><span style="font-size:14px">'+assetCode+'</span></td>'
				balData = balData+'<td class="table-borders" style="padding:5px"><span style="font-size:14px">'+balance.balance+'</span></td>'
				balData = balData+'</tr>'
			})

			balData = balData+'</table>'

			$("#data_balances").html(balData)

			return 'ok'

		})
  		.then(function(result) {
		    // console.log('Success! Results:', result);
				$("#errormsg").text("")
		})
		.catch(function(error) {
			$("#errormsg").text('The destination account does not exist!');
		   	// If the result is unknown (no response body, timeout etc.) we simply resubmit
		   	// already built transaction:
		   	// server.submitTransaction(transaction);
		});

}

function changeTrust (networkNumber) {

	$("#errormsg").text("Processing.....");

	var seckey = $("#seckey").val();

	if (networkNumber == 1) {
		var network = "public"
	} else {
		var network = "testnet"
	}

	//console.log("seckey="+seckey);

	if (seckey == "") {
		$("#errormsg").text("Please enter a Secret Key");
	} else if (seckey.length != 56) {
		$("#errormsg").text("Secret Key must be 56 characters");
	} else {

		document.getElementById("main_body").style.cursor = "wait";

		// get data

		var response = doTrust(network,seckey);

		document.getElementById("main_body").style.cursor = "default";

	}

}

function doTrust (network,seckey) {

	var sourceKeys = StellarSdk.Keypair
	  .fromSecret('SB67R6AQQTFSXD76H52BCFNQVGM6FUVXD675P5FGPDGI2UTGKYYWTY2C');
	var receivingKeys = StellarSdk.Keypair
	  .fromSecret(seckey);
	var destinationId = receivingKeys.publicKey();

	if (network == "public") {
		var server = new StellarSdk.Server("https://horizon.stellar.org");
		var networkName = StellarSdk.Networks.PUBLIC;
	} else {
		var server = new StellarSdk.Server("https://horizon-testnet.stellar.org");
		var networkName = StellarSdk.Networks.TESTNET;
	}

	// console.log('network='+network+' networkName='+networkName)

	// Transaction will hold a built transaction we can resubmit if the result is unknown.
	var transaction;

	const StellarToken = new StellarSdk.Asset('FLBS', sourceKeys.publicKey());
	// console.log('StellarToken='+StellarToken);

	server
  .loadAccount(destinationId)
  // If the account is not found, surface a nicer error message for logging.
  .catch(function (error) {
    if (error instanceof StellarSdk.NotFoundError) {
      throw new Error('The destination account does not exist!');
			$("#errormsg").text('The destination account does not exist!');
    } else return error
  })

  // step 1 - changeTrust

  // If there was no error, load up-to-date information on your account.
  .then(function() {
    return server.loadAccount(destinationId);
  })
  .then(function (receiver) {
    var transaction = new StellarSdk.TransactionBuilder(receiver, {
      fee: StellarSdk.BASE_FEE,
      networkPassphrase: networkName,
    })
      // The `changeTrust` operation creates (or alters) a trustline
      // The `limit` parameter below is optional
      .addOperation(
        StellarSdk.Operation.changeTrust({
          asset: StellarToken,
          //limit: "1000000", // unlimited
        }),
      )
      // A memo allows you to add your own metadata to a transaction. It's
      // optional and does not affect how Stellar treats the transaction.
      .addMemo(StellarSdk.Memo.text('changeTrust Transaction'))
      // setTimeout is required for a transaction
      .setTimeout(180)
      .build();
    transaction.sign(receivingKeys);
    return server.submitTransaction(transaction);
  })
  .then(function(result) {
    // console.log('Success! Results:', result);
		$("#errormsg").text('Success');
  })
  .catch(function(error) {
    console.error('Something went wrong!', error);
		$("#errormsg").text('The destination account does not exist!');
    // If the result is unknown (no response body, timeout etc.) we simply resubmit
    // already built transaction:
    // server.submitTransaction(transaction);
  });

}

function makePayment (networkNumber) {

	$("#errormsg").text("Processing.....");

	var seckey = $("#seckey").val();
	var pubkey = $("#pubkey").val();
	var amount = $("#amount").val();
	var memo = $("#memo").val();

	if (networkNumber == 1) {
		var network = "public"
	} else {
		var network = "testnet"
	}

	//console.log("seckey="+seckey);

	if (seckey == "") {
		$("#errormsg").text("Please enter a Secret Key for the sender");
	} else if (seckey.length != 56) {
		$("#errormsg").text("Secret Key must be 56 characters");
	} else if (pubkey == "") {
		$("#errormsg").text("Please enter a Public Key for the recipient");
	} else if (pubkey.length != 56) {
		$("#errormsg").text("Public Key must be 56 characters");
	} else if (amount == "" || amount <= 0) {
		$("#errormsg").text("Please enter an amount");
	} else {

		document.getElementById("main_body").style.cursor = "wait";

		// get data

		var response = doPayment(network,seckey,pubkey,amount,memo);

		document.getElementById("main_body").style.cursor = "default";

	}

}

function doPayment (network,seckey,pubkey,amount,memo) {

	var sourceKeys = StellarSdk.Keypair
	  .fromSecret(seckey);

	const destinationId = pubkey;
	const tokenAmount = amount;

	console.log('destinationId='+destinationId);
	console.log('tokenAmount='+tokenAmount);

	if (network == "public") {
		var server = new StellarSdk.Server("https://horizon.stellar.org");
		var networkName = StellarSdk.Networks.PUBLIC;
	} else {
		var server = new StellarSdk.Server("https://horizon-testnet.stellar.org");
		var networkName = StellarSdk.Networks.TESTNET;
	}

	if (memo == "") {
		memo = 'Payment Transaction';
	}

	// console.log('network='+network+' networkName='+networkName)

	// Transaction will hold a built transaction we can resubmit if the result is unknown.
	var transaction;

	const StellarToken = new StellarSdk.Asset('FLBS', sourceKeys.publicKey());
	// console.log('StellarToken='+StellarToken);

	server
  .loadAccount(destinationId)
  // If the account is not found, surface a nicer error message for logging.
  .catch(function (error) {
    if (error instanceof StellarSdk.NotFoundError) {
      throw new Error('The destination account does not exist!');
    } else return error
  })

  // step 2 - payment

  // If there was no error, load up-to-date information on your account.
  .then(function() {
    return server.loadAccount(sourceKeys.publicKey());
  })

  .then(function(sourceAccount) {
    // Start building the transaction.
    transaction = new StellarSdk.TransactionBuilder(sourceAccount, {
      fee: StellarSdk.BASE_FEE,
      networkPassphrase: networkName
    })
      .addOperation(StellarSdk.Operation.payment({
        destination: destinationId,
        // Because Stellar allows transaction in many currencies, you must
        // specify the asset type. The special "native" asset represents Lumens.
        asset: StellarToken,
        amount: tokenAmount
      }))
      // A memo allows you to add your own metadata to a transaction. It's
      // optional and does not affect how Stellar treats the transaction.
      .addMemo(StellarSdk.Memo.text(memo))
      // Wait a maximum of three minutes for the transaction
      .setTimeout(180)
      .build();
    // Sign the transaction to prove you are actually the person sending it.
    transaction.sign(sourceKeys);
    // And finally, send it off to Stellar!
    return server.submitTransaction(transaction);
  })
  .then(function(result) {
    console.log('Success! Results:', result);
  })
  .catch(function(error) {
    console.error('Something went wrong!', error);
    // If the result is unknown (no response body, timeout etc.) we simply resubmit
    // already built transaction:
    // server.submitTransaction(transaction);
  });

}

function ChangeNetwork (status) {

	document.body.style.cursor = "progress";
	AjaxInitial = $.post("/change_network.php", {
		network_status: status
	},
	function(response) {

		document.body.style.cursor = "default";
		window.location.href = '/admin_balance.php';

	})

}

function ApprovalsPage (pageNo) {

	var ajaxURL = "/admin_pagination.php";

	if (pageNo > 0) {

		document.body.style.cursor = "progress";
		AjaxInitial = $.post(ajaxURL, {
			pageNo: pageNo
		},
		function(response) {

			document.body.style.cursor = "default";
			window.location.href = '/admin_approvals.php';

		})

	}

}

function alphanumericLower(inputtxt) {

	var letters = /^[0-9a-z]+$/;

	if(inputtxt.match(letters))
	{
		return true;
	}
	else
	{
		return false;
	}

}

function checkPassword(inputtxt) {

	var letters = /^[0-9a-zA-Z^_]+$/;

	if(inputtxt.match(letters))
	{
		return true;
	}
	else
	{
		return false;
	}

}

function SearchMember () {

	//$("#errormsg").text("");

	var member_search = $("#member_search").val();

	// console.log("member_search="+member_search);

	if (member_search == "") {

	} else {

		document.body.style.cursor = "progress";
		AjaxInitial = $.post("/admin_member_search.php", {
			member_search: member_search
		},
		function(response) {

			document.body.style.cursor = "default";
			window.location.href = '/admin_member_list.php';

		})

	}

}

function SearchMemberReset () {

	var member_search = "";

	document.body.style.cursor = "progress";
	AjaxInitial = $.post("/admin_member_search.php", {
		member_search: member_search
	},
	function(response) {

		document.body.style.cursor = "default";
		window.location.href = '/admin_member_list.php';

	})

}
