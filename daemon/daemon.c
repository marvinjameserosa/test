#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>

// ANSI color codes for styling
#define RESET   "\033[0m"
#define RED     "\033[31m"
#define GREEN   "\033[32m"
#define YELLOW  "\033[33m"
#define BLUE    "\033[34m"
#define MAGENTA "\033[35m"
#define CYAN    "\033[36m"
#define WHITE   "\033[37m"
#define BOLD    "\033[1m"
#define DIM     "\033[2m"

void clear_screen() {
    printf("\033[2J\033[H");
}

void slow_print(const char* text, int delay_ms) {
    for (int i = 0; text[i] != '\0'; i++) {
        printf("%c", text[i]);
        fflush(stdout);
        usleep(delay_ms * 1000);
    }
}

void print_banner() {
    printf(CYAN BOLD);
    printf("╔══════════════════════════════════════════════════════════════════════════╗\n");
    printf("║                                                                          ║\n");
    printf("║   ██████╗██╗   ██╗██████╗ ███████╗██████╗ ███╗   ██╗ █████╗ ██╗   ██╗████████╗ ║\n");
    printf("║  ██╔════╝╚██╗ ██╔╝██╔══██╗██╔════╝██╔══██╗████╗  ██║██╔══██╗██║   ██║╚══██╔══╝ ║\n");
    printf("║  ██║      ╚████╔╝ ██████╔╝█████╗  ██████╔╝██╔██╗ ██║███████║██║   ██║   ██║    ║\n");
    printf("║  ██║       ╚██╔╝  ██╔══██╗██╔══╝  ██╔══██╗██║╚██╗██║██╔══██║██║   ██║   ██║    ║\n");
    printf("║  ╚██████╗   ██║   ██████╔╝███████╗██║  ██║██║ ╚████║██║  ██║╚██████╔╝   ██║    ║\n");
    printf("║   ╚═════╝   ╚═╝   ╚═════╝ ╚══════╝╚═╝  ╚═╝╚═╝  ╚═══╝╚═╝  ╚═╝ ╚═════╝    ╚═╝    ║\n");
    printf("║                                                                              ║\n");
    printf("║                      " YELLOW "「 CYBERNAUT SECURITY DAEMON 」" CYAN "                      ║\n");
    printf("║                                                                  ║\n");
    printf("╚══════════════════════════════════════════════════════════════════════════╝\n");
    printf(RESET "\n");
}

void print_system_info() {
    printf(DIM "Protocol: " RESET "Neural Network Interface v3.7\n");
    printf(DIM "Status: " RESET "Cyberspace Gateway Online\n");
    printf(DIM "Security: " RESET "Level DELTA - Cybernaut Access\n");
    printf(DIM "Location: " RESET "Digital Nexus - Core Node 001\n");
    printf("\n");
}

void loading_animation() {
    printf(YELLOW "Initializing secure connection");
    for (int i = 0; i < 6; i++) {
        printf(".");
        fflush(stdout);
        usleep(300000);
    }
    printf(GREEN " [CONNECTED]\n" RESET);
    usleep(500000);
}

void access_granted_animation() {
    printf("\n" GREEN BOLD "✓ AUTHENTICATION SUCCESSFUL\n" RESET);
    printf("Welcome, Cybernaut.\n");
    printf("The digital realm awaits your command.\n\n");
    
    printf(DIM "Establishing neural link");
    for (int i = 0; i < 4; i++) {
        printf(".");
        fflush(stdout);
        usleep(200000);
    }
    printf(GREEN " [SYNCHRONIZED]\n" RESET);
}

void access_denied_animation() {
    printf("\n" RED BOLD "✗ ACCESS DENIED\n" RESET);
    printf("Invalid credentials detected.\n");
    printf("Security breach attempt logged.\n\n");
    
    printf(RED DIM "Initiating firewall protocols");
    for (int i = 0; i < 3; i++) {
        printf(".");
        fflush(stdout);
        usleep(300000);
    }
    printf(" [INTRUSION BLOCKED]\n" RESET);
}

int main(void) {
    const char *password = "SEEN{H4rdc0ded_Str1ngs_Are_A_Gift}";
    char input[256];
    
    // Clear screen and show loading
    clear_screen();
    loading_animation();
    
    // Main interface
    print_banner();
    print_system_info();
    
    // Authentication prompt
    printf(YELLOW "⚠ WARNING:" RESET " This system contains classified data.\n");
    printf("Unauthorized access is prohibited and will be prosecuted.\n\n");
    
    printf(CYAN "Enter authentication key: " RESET);
    fgets(input, sizeof(input), stdin);
    
    // Strip newline
    input[strcspn(input, "\r\n")] = 0;
    
    // Simulate processing
    printf("\n" YELLOW "Verifying credentials");
    for (int i = 0; i < 4; i++) {
        printf(".");
        fflush(stdout);
        usleep(400000);
    }
    printf("\n");
    
    // Check password
    if (strcmp(input, password) == 0) {
        access_granted_animation();
        printf(GREEN DIM "Neural interface active. Welcome to the grid, Cybernaut.\n" RESET);
    } else {
        access_denied_animation();
        printf(RED DIM "Connection severed. Cyber-trace initiated.\n" RESET);
    }
    
    return 0;
}