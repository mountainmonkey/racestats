#include <stdio.h>

int main(int argc,char *argv[])
{
    int i,j;
    char line[200];
    char ignore[10],sp_label[10],place[10],gplace[10],cplace[10],name[10],city[10],bib[10],category[10],guntime[10],chiptime[10],split[10];
    FILE *fp;

    printf("%s\n",argv[1]);
    fp=fopen(argv[1],"r");

    for (i=0;i<24;i++)
    {
        fgets(line,200,fp);
        printf("%2d. %s",i,line);

    }
    fclose(fp);

    for (i=0;i<strlen(line);i++,j++)
    {
        if (i%10==0)
            j=0;
        putchar('0'+j);
    }
    

    printf("lines to ignore: ");
    fgets(ignore,10,stdin);
    printf("split point label: ");
    fgets(sp_label,10,stdin);
    printf("place: ");
    fgets(place,10,stdin);
    printf("gplace: ");
    fgets(gplace,10,stdin);
    printf("cplace: ");
    fgets(cplace,10,stdin);
    printf("name: ");
    fgets(name,10,stdin);
    printf("city: ");
    fgets(city,10,stdin);
    printf("bib: ");
    fgets(bib,10,stdin);
    printf("category: ");
    fgets(category,10,stdin);
    printf("guntime: ");
    fgets(guntime,10,stdin);
    printf("chiptime: ");
    fgets(chiptime,10,stdin);
    printf("split: ");
    fgets(split,10,stdin);

    printf("%s\n",ignore);
    printf("%s\n",sp_label);
    printf("%s\n",place);
    printf("%s\n",gplace);
    printf("%s\n",cplace);
    printf("%s\n",name);
    printf("%s\n",city);
    printf("%s\n",bib);
    printf("%s\n",category);
    printf("%s\n",guntime);
    printf("%s\n",chiptime);
    printf("%s\n",split);
}

/*
lines_to_ignore
split_label
place
gplace
cplace
name
city
bib
category
guntime
chiptime
split
*/
