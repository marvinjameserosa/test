#include <stdio.h>
#include <string.h>

int main(void) {
    const char *password = "SEEN{H4rdc0ded_Str1ngs_Are_A_Gift}";
    char input[256];

    printf("[Architect's Daemon] Authentication required.\n");
    printf("Enter password: ");
    fgets(input, sizeof(input), stdin);

    // Strip newline
    input[strcspn(input, "\r\n")] = 0;

    if (strcmp(input, password) == 0) {
        printf("Access granted.\n");
    } else {
        printf("Access denied.\n");
    }
    return 0;
}
