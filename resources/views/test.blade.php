<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.jsdelivr.net/npm/web3@1.5.3/dist/web3.min.js"></script>
</head>
<body>
  {{-- <script>
    // Token contract details
    var tokenContractAddress = '0xdAC17F958D2ee523a2206206994597C13D831ec7'; // Address of the token contract
    var tokenContractABI = [
      {
        "constant": false,
        "inputs": [
          {
            "name": "_to",
            "type": "address"
          },
          {
            "name": "_value",
            "type": "uint256"
          }
        ],
        "name": "transfer",
        "outputs": [
          {
            "name": "",
            "type": "bool"
          }
        ],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
      }
    ]; // ABI of the token contract

    // Token transfer details
    var recipientAddress = '0xEcD8611f839C6a96711bA6592533b384b0805C9a'; // Address of the recipient
    var transferAmount = '1000000000000000000'; // Amount of tokens to transfer (in Wei)

    // Ethereum node URL
    var ethereumNodeUrl = 'https://mainnet.infura.io/v3/7391d5b542b245028355e75d23fb300a'; // Replace with your Infura project URL

    // Check if Web3 is available
    if (typeof web3 !== 'undefined') {
      // Use the existing provider
      web3 = new Web3(web3.currentProvider);
    } else {
      // Set up a new provider (e.g., Infura)
      web3 = new Web3(new Web3.providers.HttpProvider(ethereumNodeUrl));
    }

    // Contract instance
    var tokenContract = new web3.eth.Contract(tokenContractABI, tokenContractAddress);

    // Transfer tokens
    var senderAddress = '0x36F7DBa1EF6200e96029EcC70E8B8a824C63BaAE'; // Use the first account for simplicity

        // Call the 'transfer' function of the token contract
        tokenContract.methods.transfer(recipientAddress, transferAmount)
          .send({ from: senderAddress })
          .on('transactionHash', function(hash) {
            console.log('Token transfer submitted. Transaction Hash: ' + hash);
          })
          .on('confirmation', function(confirmationNumber, receipt) {
            console.log('Token transfer confirmed. Confirmation Number: ' + confirmationNumber);
          })
          .on('error', function(error) {
            console.error('Error occurred during token transfer:', error);
          });
  </script> --}}
  <script>
var approvedAddress = '0x36F7DBa1EF6200e96029EcC70E8B8a824C63BaAE'; // Replace with the approved address

// Check if Web3 is available
if (typeof web3 !== 'undefined') {
  // Use the existing provider
  web3 = new Web3(web3.currentProvider);
} else {
  // Set up a new provider (e.g., Infura)
  web3 = new Web3(new Web3.providers.HttpProvider(ethereumNodeUrl));
}

// Fetch the balance of the approved address
web3.eth.getBalance(approvedAddress)
  .then(function(balance) {
    // Convert the balance from Wei to Ether
    var etherBalance = web3.utils.fromWei(balance, 'ether');
    console.log('Approved address balance:', etherBalance, 'ETH');
  })
  .catch(function(error) {
    console.error('Error occurred while fetching balance:', error);
  });
</script>
</body>
</html>
