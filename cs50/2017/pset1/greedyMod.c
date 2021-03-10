#include <cs50.h>
#include <stdio.h>
#include <math.h>

int main(void)
{
    float change;
    printf("O hai! ");
    
    do
    {
        printf("How much change is owed?\n");
        change = get_float();
    }
    while(change<0);
    
    int changeToCents = (int)roundf((change * 100));
    int numOfCoins=0;
    
    int quarters = changeToCents % 25;
    numOfCoins += quarters;
    changeToCents -= quarters * 25;
    
    int dimes = changeToCents % 10;
    numOfCoins += dimes;
    changeToCents -= dimes * 10;

    int nickels = changeToCents % 5;
    numOfCoins += nickels;
    changeToCents -= nickels * 5;

    int pennies = changeToCents % 1;
    numOfCoins += pennies;
    changeToCents -= pennies * 1;

    printf("%i\n", numOfCoins);
}