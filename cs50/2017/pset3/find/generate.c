/**
 * generate.c
 *
 * Generates pseudorandom numbers in [0,MAX), one per line.
 *
 * Usage: generate n [s]
 *
 * where n is number of pseudorandom numbers to print
 * and s is an optional seed
 */

#define _XOPEN_SOURCE

#include <cs50.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>

// upper limit on range of integers that can be generated
#define LIMIT 65536

int main(int argc, string argv[])
{
    //Command must have 1 or 2 additional inputs to ./generate
    if (argc != 2 && argc != 3)
    {
        printf("Usage: ./generate n [s]\n");
        return 1;
    }

    //Converts the first input to an integer.
    int n = atoi(argv[1]);

    //Confirms there's a seed, uses that as an initialization for drand48.
    //Otherwise it uses the amount of time elapsed since Jan 1, 1970 (the epoch) as a seed
    if (argc == 3)
    {
        srand48((long) atoi(argv[2]));
    }
    else
    {
        srand48((long) time(NULL));
    }

    for (int i = 0; i < n; i++) //Prints out [argc] generated numbers
    {
        printf("%i\n", (int) (drand48() * LIMIT));
    }

    // success
    return 0;
}