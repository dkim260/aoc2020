#include <stdio.h>
#include <cs50.h>
#include <ctype.h>
#include <string.h>
#include <stdlib.h>

int asciiReference (char decipheringChar);
int encipherText(int reference, int key);
int referenceToAscii (int encipheredReference, char decipheringChar);
void caesar (string key);

int main (int argc, string argv[])
{
    if (argc != 2)
    {
        printf("Usage: ./caesar k\n");
        return 1;
    }
    else
    {
        bool keyWorks = true;
        for (int x=0, i=strlen(argv[1]); x<i; x++)
        {
            if (!isalpha(argv[1][x]))
            {
                keyWorks=false;
                printf("Usage: ./caesar k\n");
                return 1;
            }
        }
        if (keyWorks==true)
        {
            caesar(argv[1]);
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


void caesar(string stringKey)
{
    printf("plaintext: ");
    string plaintext = get_string();
    printf("ciphertext: ");
    for (int x=0, i=strlen(plaintext), j=strlen(stringKey), y=x; x<i; x++, y++)
    {
        if (isalpha(plaintext[x]))
        {
            int asciiRef = asciiReference(plaintext[x]);
            int asciiRefKey = asciiReference(stringKey[y%j]);
            int encipheredReference = encipherText(asciiRef, asciiRefKey);
            int encipheredChar = referenceToAscii (encipheredReference, plaintext[x]);
            printf("%c", encipheredChar);
        }
        else
        {
            y--;
            printf("%c", plaintext[x]);
        }
    }
}
