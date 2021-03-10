#include <stdio.h>
#include <cs50.h>
#include <ctype.h>
#include <string.h>
#include <stdlib.h>

int asciiReference (char decipheringChar);
int encipherText(int reference, int key);
int referenceToAscii (int encipheredReference, char decipheringChar);

int main (int argc, string argv[])
{
    if (argc != 2 || !isalpha(atoi(argv)))
    {
        printf("Usage: ./caesar k\n");
        return 1;
    }
    else
    {
        int key = atoi(argv[1]);
        printf("plaintext: ");
        string plaintext = get_string();
        printf("ciphertext: ");

        for (int x=0, i=strlen(plaintext); x<i; x++)
        {
            if (isalpha(plaintext[x]))
            {
                int asciiRef = asciiReference(plaintext[x]);
                int encipheredReference = encipherText(asciiRef, key);
                int encipheredChar = referenceToAscii (encipheredReference, plaintext[x]);
                printf("%c", encipheredChar);
            }
            else
            {
                printf("%c", plaintext[x]);
            }
        }
    }
    printf("\n");
}

int asciiReference (char decipheringChar)
{
    int asciiRef=0;
    if (isupper(decipheringChar))
    {
        for (int x=65; x<=90; x++)
        {
            if (decipheringChar==x)
            {
                asciiRef=x-65;
            }
        }
    }
    else
    {
        for (int x=97; x<=122; x++)
        {
            if (decipheringChar==x)
            {
                asciiRef=x-97;
            }
        }
    }
    return asciiRef;
}

int encipherText (int reference, int key)
{
    return ((reference + key) % 26);
}

int referenceToAscii (int encipheredReference, char decipheringChar)
{
    int backToAscii=0;
    if (isupper(decipheringChar))
    {
        backToAscii = encipheredReference + 65;
    }
    else
    {
        backToAscii = encipheredReference + 97;
    }
    return backToAscii;
}