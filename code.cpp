#include <stdio.h>
#include <ctype.h>

int main() {
    FILE *file = fopen("filename.txt", "r");
    if (!file) {
        printf("Cannot open file.\n");
        return 1;
    }

    int c, chars = 0, words = 0, lines = 0;
    int inWord = 0;

    while ((c = fgetc(file)) != EOF) {
        chars++;

        if (c == '\n') lines++;

        if (isspace(c))
            inWord = 0;
        else if (!inWord) {
            inWord = 1;
            words++;
        }
    }

    if (chars > 0 && c != '\n') lines++;

    fclose(file);

    printf("Characters: %d\nWords: %d\nLines: %d\n", chars, words, lines);
    return 0;
}
