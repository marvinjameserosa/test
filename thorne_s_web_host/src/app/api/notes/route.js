import { NextResponse } from "next/server";

export async function POST(request) {
  try {
    const data = await request.json();
    const { password } = data;
    if (password.includes("Th0rn3") || password.includes("<script>")) {
      const notes = `
Personal notes - PRIVATE
-----------------------
April 15: Project Sentinel reached phase 2
April 22: Meeting with investors went well
May 3: Security concerns about the web interface

TODO LIST:
- Fix server vulnerabilities
- Update encryption keys
- Meet with the team about input validation

IMPORTANT: SEEN{the_key_is_cybernaut}

-----------------------
Remember to properly secure this notebook later!
`;

      return NextResponse.json({ success: true, notes });
    }
    return NextResponse.json({
      success: false,
      error: "Invalid credentials",
    });
  } catch (error) {
    return NextResponse.json(
      {
        success: false,
        error: "Server error",
      },
      { status: 500 }
    );
  }
}
