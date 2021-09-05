<?php
class machineProduct
{
    public int $price;
    public string $name;

    function __construct(int $price, string $name)
    {
        $this->price = $price;
        $this->name = $name;
    }
    public function displayProduct():string
    {
        return $this->name.' for '.$this->price;
    }
}
class VendingMachine
{
    private machineProduct $machine;

    function __construct(machineProduct $machine)
    {
        $this->machine = $machine;
    }
    public function displayProducts()
    {
        echo 'Welcome to Coffee machine ! '.PHP_EOL;
        echo 'Available '.$this->machine->displayProduct().' cents'.PHP_EOL;
    }
    public function validateMoney(int $coin,Wallet $customerWallet):bool
    {
        foreach ($customerWallet->wallet as $money)
        {
            if($coin === $money->value && $money->quantity > 0)
            {
                $money->quantity--;
                return true;
            }
        }
        return false;
    }
    public function payForCoffee(Wallet $customerWallet)
    {
        echo PHP_EOL;
        If(readline("Enter 'buy' to pay for coffee --> ") === 'buy')
        {
            $payedAmount = 0;
            while($payedAmount < $this->machine->price)
            {
                $leftToPay = $this->machine->price-$payedAmount;
                echo 'Left to pay '.$leftToPay.' cents'.PHP_EOL;
                $coin = readline('Enter money to put in : ');
                $coin =(int) $coin;
                if(!$this->validateMoney($coin,$customerWallet)){
                    echo 'No such money in your wallet '.PHP_EOL;
                    continue;
                }
                $payedAmount += $coin;

                if($payedAmount > $this->machine->price)
                {
                    $overpaid= $payedAmount-$this->machine->price;
                    $customerWallet->returnMoney($overpaid);
                    echo 'Returned '.$overpaid.' cents'.PHP_EOL;
                }
            }
        }
        echo 'Thanks for buying coffee'.PHP_EOL;
    }
}
class Money
{
    public int $value;
    public int $quantity;

    function __construct(int $value, int $quantity)
    {
        $this->value = $value;
        $this->quantity = $quantity;
    }
}
class Wallet
{
    public array $wallet;
    public function addMoneyTypes(array $moneyTypes)
    {
        $this->wallet = $moneyTypes;
    }
    public function returnMoney(int $amount)
    {
        foreach ($this->wallet as $money)
        {
            $coinCount = intdiv($amount, $money->value);
            $money->quantity += $coinCount;
            $amount -= $coinCount*$money->value;
        }
    }
}
$coffee = new machineProduct(80,'coffee');
$coffeeMachine = new VendingMachine($coffee);

$moneyTypes = [
    $cent200 = new Money(200,1),
    $cent100 = new Money(100,1),
    $cent50 = new Money(50,2),
    $cent20 = new Money(20,3),
    $cent10 = new Money(10,5),
    $cent5 = new Money(5,5),
    $cent2 = new Money(2,5),
    $cent1 = new Money(1,10)

];
$myWallet = new Wallet();
$myWallet->addMoneyTypes($moneyTypes);

$coffeeMachine->displayProducts();
$coffeeMachine->payForCoffee($myWallet);