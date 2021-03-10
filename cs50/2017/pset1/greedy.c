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
    
    while (changeToCents >= 25)
    {
        changeToCents = changeToCents - 25;
        numOfCoins = numOfCoins +1;
    }
    while (changeToCents >= 10)
    {
        changeToCents = changeToCents - 10;
        numOfCoins = numOfCoins +1;
    }
    while (changeToCents >= 5)
    {
        changeToCents = changeToCents-5;
        numOfCoins++;
    }
    while (changeToCents >= 1)
    {
        changeToCents = changeToCents-1;
        numOfCoins++;
    }
    printf("%i\n",numOfCoins);
    
}