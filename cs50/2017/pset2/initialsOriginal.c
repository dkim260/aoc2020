#include <stdio.h>
#include <string.h>
#include <cs50.h>
#include <ctype.h>

void cleanName (string name);

int main (void)
{
    
    string name = get_string();

    //I overthought this like crazy. I didn't have to make another string to print it out.
    cleanName(name);

    char initials [strlen(name)];
    initials[0] = toupper(name[0]);//Initalize the first letter to be the first letter of the sentence.
    int numOfInitials=1; //Start at 1 for the next letter, numOfInitials++ does not immediately add to 0.
    
    for (int i=0, j=strlen(name); i<j; i++)
    {
        if (name[i]==' ')
        {
            if (name[i+1]!=' ' && name[i-1]!=' ')
            {
                initials[numOfInitials++] = toupper(name[i+1]); //If there is a space, that means the character after the space must be a letter.
            }
        }
    }
    
    printf("%s\n",initials);
}

void cleanName (string name)
{
    for (int a=0, b=strlen(name); a<b; a++)
    {
        
        if (a==0)
        {
            while (name[a]==' ')
            {
                for (int x=0, y=b, j=x+1; x<y; x++,j++)
                {
                    name[x]=name[j];
                }
            }
        }
        else
        {
            while (name[a]==' ' && name[a+1]==' ')
            {
                for (int x=a, y=b, j=x+1; x<y&&j<y; x++,j++)
                {
                    name[x]=name[j];
                }
            }
        }
    }
}