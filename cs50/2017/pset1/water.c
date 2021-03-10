#include <cs50.h>
#include <stdio.h>

int main(void)
{
    int numberOfBottles;
    do 
    {
        printf("Minutes: ");
        numberOfBottles = get_int();
    }
    while(numberOfBottles<0);
    printf("Bottles: %i\n", numberOfBottles * 12);
}