#include <stdio.h>
#include <string.h>
#include <cs50.h>
#include <ctype.h>

int main (void)
{
    string name = get_string();
    for (int x=0, i=strlen(name); x<i; x++)
    {
        if (x==0 && name[x]!=' ')
        {
            printf("%c", toupper(name[0]));
        }
        else
        {
            if (name[x]==' ')
            {
                if (isalpha(name[x+1]))
                {
                     printf("%c", toupper(name[x+1]));
                }
            }
        }
    }
    printf("\n");
}