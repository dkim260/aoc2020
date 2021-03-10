/**
 * helpers.c
 *
 * Helper functions for Problem Set 3.
 */

#include <cs50.h>
#include <stdio.h>

#include "helpers.h"

/**
 * Returns true if value is in array of n values, else false.
 */
bool search(int value, int values[], int n)
{
    bool doesExist=false;
    if (n < 1)
    {
        doesExist=false;
    }
    else
    {
        //Binary search
        int start = 0;
        int middle = 0;

        while ((start - n) != 0 && start < n)
        {
            middle=0;
            middle += start;
            middle += n;
            middle = middle/2;

            if (values[middle]==value)
            {
                start=0;
                n=0;
                doesExist=true;
            }
            else
            {
                if (values[middle]>value)
                {
                    n = middle;
                }
                if (values[middle]<value)
                {
                    start += middle;
                }
            }
        }
    }
    return doesExist;
}


/**
 * Sorts array of n values.
 */
void sort(int values[], int n)
{

    //Bubble Sort
    int swapCounter=-1;
    while(swapCounter!=0)
    {
        swapCounter=0;
        int placeHolder=0;
        for (int x=0; x<(n-1); x++)
        {
            if (values[x]>values[x+1])
            {
                placeHolder = values[x];
                values[x]=values[x+1];
                values[x+1]=placeHolder;
                swapCounter++;
            }
        }
        n--;
    }
   return;
}