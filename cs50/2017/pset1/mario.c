#include <stdio.h>
#include <cs50.h>

void makePyramid(int n);

int main (void)
{
    int numOfRows;
    do
    {
        printf("Height: ");
        numOfRows = get_int();
    }
    while(numOfRows<0 || numOfRows>23);
    makePyramid(numOfRows);

}

void makePyramid(int numOfRows)
{
        for (int currentHashCount=0; currentHashCount<numOfRows; currentHashCount++)//The number of hashes start at 0, I must + 1 to the currentHashCount for my other statements
    {
        for (int y=0; y<numOfRows-currentHashCount-1; y++)
        {
            printf(" ");
            //This for loop prints out the number of spaces required for the left hand side of the pyramid.
            //Maximum number of hashes for the largest height - current number of hashes = the number of spaces needed. Must - 1 because number of rows is one more than 0th number of hash 
        }
        for (int y=0; y<currentHashCount+1; y++)
        {
            printf("#");
            //This for loop prints out the number of hashes required for the left hand side of the pyramid. +1 because 
        }
        printf("  "); //This printf prints out the two spaces needed for the gap
        
        for (int y=0; y<currentHashCount+1; y++)
        {
            printf("#");
            //This for loop prints out the number of hashes of the nth height + 1.
        }
        printf("\n");
    }
}