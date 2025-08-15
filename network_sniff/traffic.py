# generate_traffic.py
# Project: VoidSignal — Futuristic Military Cyber Warfare Simulation
# Authored: [Your Name], Interstellar Defense Net (IDN) — 2187
# Purpose: Simulate encrypted, stealthy, AI-optimized battlefield comms for AI training and threat modeling.

from scapy.all import *
import random
import string
import time
import hashlib
from datetime import datetime
import base64

# --- CONFIGURATION ---
# Military-grade settings
MISSION_ID = "VX-7742-OMEGA"
OPERATION_NAME = "Shadow Reckoning"
TIMESTAMP = int(time.time())
SECTOR = "Sector-9 (Proxima Centauri Expanse)"
FREQ = 100  # Hz — High-frequency burst transmission
PACKETS_PER_SEC = 100  # Burst rate
TOTAL_PACKETS = 10000  # Total generated

# Encryption and obfuscation
ENCRYPTION_KEY = b"XyZ-7F3aKqWmP9sLxN2vB4hJcRtE6dP1oM8nT5z"
SIGNAL_ID = "SIGNAL-7742-OMEGA-0x8B3C9A"

# --- HELPER FUNCTIONS ---
def random_mac():
    return ":".join(["{:02x}".format(random.randint(0, 255)) for _ in range(6)])

def random_ipv4():
    return ".".join([str(random.randint(1, 254)) for _ in range(4)])

def random_str(length=10):
    return ''.join(random.choices(string.ascii_letters + string.digits, k=length))

def obfuscate_payload(data: str) -> str:
    # Simulate AI-generated obfuscation (XOR + base64 + padding)
    key = ENCRYPTION_KEY[0]
    xor = ''.join(chr(ord(c) ^ key) for c in data)
    return base64.b64encode(xor.encode()).decode() + "==" + random_str(8)

def generate_encrypted_header():
    return (
        f"X-Auth: {SIGNAL_ID}\r\n"
        f"X-Source: {random_mac()}\r\n"
        f"X-Node: {random_ipv4()}\r\n"
        f"X-Timestamp: {TIMESTAMP}\r\n"
        f"X-Encryption: AES-256-CTR-IV-9B3D2A\r\n"
        f"X-Noise: {random_str(16)}\r\n"
        f"X-Checksum: {hashlib.sha3_256(f'{TIMESTAMP}{random_str(12)}'.encode()).hexdigest()[:16]}\r\n"
    )

# --- MAIN PACKET GENERATION ---
packets = []

# --- 1. Stealthy DNS Beacon (Military Beaconing) ---
# Uses DNS over UDP with randomized query patterns and encoded payload
print("Generating DNS beacons...")
for i in range(1000):
    qname = f"beacon.{random_str(6)}.sec.{random.choice(['xenon', 'neutron', 'quantum'])}.idn"
    dns = Ether(dst="ff:ff:ff:ff:ff:ff", src=random_mac()) / IP(src=random_ipv4(), dst="8.8.8.8") / UDP(sport=5353, dport=53) / DNS(
        qd=DNSQR(qname=qname),
        an=DNSRR(rrname=qname, rdata="1.2.3.4", type=1, ttl=60)
    )
    packets.append(dns)

# --- 2. Quantum-Encrypted ICMP Ping (Stealth Ping) ---
# Uses random payload, quantum noise, and fake "ghost" replies
print("Generating ICMP traffic...")
for i in range(1500):
    icmp_payload = f"Q-ECO-{random_str(4)}-{random.randint(1, 9999)}-PING"
    icmp = Ether(dst=random_mac(), src=random_mac()) / IP(src=random_ipv4(), dst=random_ipv4(), ttl=64) / ICMP() / Raw(load=icmp_payload)
    packets.append(icmp)

# --- 3. AI-Generated HTTP Traffic (Simulated Mission Data) ---
# Realistic military web traffic: encrypted login, data sync, AI reporting
print("Generating HTTP traffic...")
for i in range(500):  # Reduced count to avoid too many packets
    # Random mission ID and target
    mission = random.choice(["RECON-9", "TACTICAL-OMEGA", "SIGINT-7", "CIPHER-4"])
    src_ip = random_ipv4()
    dst_ip = random_ipv4()
    src_port = random.randint(1024, 65535)
    path = random.choice([
        "/mission/report",
        "/ai/analysis", 
        "/data/transfer",
        "/log/encrypted",
        "/command/execute"
    ])
    user_agent = random.choice([
        "AI-Unit-7/2.1.3 (QuantumNet)",
        "Drone-Link-3.0 (Class-9)",
        "SentryBot-Alpha/1.2"
    ])
    
    # Simulate real data
    content = f"MISSION={mission}&TARGET={dst_ip}&DATA_ID={random_str(8)}&TIMESTAMP={TIMESTAMP}&STATUS=ACTIVE"
    
    # HTTP request payload
    http_payload = (
        f"POST {path} HTTP/1.1\r\n"
        f"Host: {random.choice(['secure.idn', 'ai-core.idn', 'net-9.idn'])}\r\n"
        f"Content-Type: application/x-www-form-urlencoded\r\n"
        f"Content-Length: {len(content)}\r\n"
        f"User-Agent: {user_agent}\r\n"
        f"X-Session-ID: {random_str(12)}\r\n"
        f"X-Region: {SECTOR}\r\n"
        f"X-Auth-Token: {base64.b64encode(f'{TIMESTAMP}:{random_str(10)}'.encode()).decode()}\r\n"
        f"Connection: keep-alive\r\n"
        f"\r\n"
        f"{content}"
    )
    
    # TCP SYN
    syn = Ether(src=random_mac(), dst=random_mac()) / IP(src=src_ip, dst=dst_ip) / TCP(sport=src_port, dport=80, flags="S", seq=1000)
    packets.append(syn)
    
    # TCP SYN-ACK
    syn_ack = Ether(src=random_mac(), dst=random_mac()) / IP(src=dst_ip, dst=src_ip) / TCP(sport=80, dport=src_port, flags="SA", seq=2000, ack=1001)
    packets.append(syn_ack)
    
    # TCP ACK
    ack = Ether(src=random_mac(), dst=random_mac()) / IP(src=src_ip, dst=dst_ip) / TCP(sport=src_port, dport=80, flags="A", seq=1001, ack=2001)
    packets.append(ack)
    
    # HTTP request
    http_req = Ether(src=random_mac(), dst=random_mac()) / IP(src=src_ip, dst=dst_ip) / TCP(sport=src_port, dport=80, flags="PA", seq=1001, ack=2001) / Raw(load=http_payload)
    packets.append(http_req)
    
    # HTTP response
    http_response = (
        "HTTP/1.1 200 OK\r\n"
        "Content-Type: application/json\r\n"
        f"Content-Length: {len('{\"status\":\"success\"}')}\r\n"
        "Server: IDN-SecureNet/2.1\r\n"
        "\r\n"
        "{\"status\":\"success\"}"
    )
    
    http_resp = Ether(src=random_mac(), dst=random_mac()) / IP(src=dst_ip, dst=src_ip) / TCP(sport=80, dport=src_port, flags="PA", seq=2001, ack=1001+len(http_payload)) / Raw(load=http_response)
    packets.append(http_resp)

# --- 4. Encrypted Data Transfer (Military Payload) ---
# Simulates transfer of encrypted intelligence files
print("Generating encrypted transfers...")
for i in range(200):  # Reduced to avoid excessive packets
    payload = f"INTL-FILE-{random.randint(1000, 9999)}-XRAY-ENCRYPTED"
    encoded_payload = obfuscate_payload(payload)
    file_size = random.randint(1024, 10240)  # Smaller files for demo
    src_ip = random_ipv4()
    dst_ip = random_ipv4()
    src_port = random.randint(1024, 65535)
    
    # Simulate a few chunks instead of full file
    for chunk in range(0, min(file_size, 3072), 1024):  # Max 3 chunks
        chunk_data = f"CHUNK-{chunk//1024}-{random_str(6)}-{encoded_payload[:16]}"
        
        http_payload = (
            f"PUT /transfer/file?chunk={chunk//1024}&total={file_size//1024} HTTP/1.1\r\n"
            f"Host: secure.idn\r\n"
            f"Content-Type: application/octet-stream\r\n"
            f"Content-Length: {len(chunk_data)}\r\n"
            f"X-Transfer-ID: {random_str(16)}\r\n"
            f"X-Progress: {chunk/file_size:.2%}\r\n"
            f"X-Auth: {SIGNAL_ID}\r\n"
            f"Connection: close\r\n"
            f"\r\n"
            f"{chunk_data}"
        )
        
        http_put = Ether(src=random_mac(), dst=random_mac()) / IP(src=src_ip, dst=dst_ip) / TCP(sport=src_port, dport=443, flags="PA", seq=1000+chunk, ack=2000) / Raw(load=http_payload)
        packets.append(http_put)

# --- 5. AI-Driven Stealth Communication (AI Beaconing) ---
# Simulates AI-generated background chatter and encrypted signals
print("Generating AI beacons...")
for i in range(500):
    # AI chatter with fake "thought" patterns
    ai_thought = random.choice([
        "Processing threat vector 7.17...",
        "Neural net sync: 98.7% complete",
        "Target acquisition: locked",
        "Signal degradation detected — rerouting...",
        "Quantum buffer full — initiating flush"
    ])
    
    # Encrypted AI message
    encrypted_thought = base64.b64encode(ai_thought.encode()).decode() + "++" + random_str(10)
    
    # Simulate encrypted beacon
    beacon_payload = f"AI-BEACON:{TIMESTAMP}:{encrypted_thought}:{random_str(8)}:SIG-OMEGA"
    beacon = Ether(src=random_mac(), dst=random_mac()) / IP(src=random_ipv4(), dst="192.168.1.100") / UDP(sport=54321, dport=54321) / Raw(load=beacon_payload)
    packets.append(beacon)

# --- 6. Flag in HTTP POST Data ---
# Flag hidden in HTTP form data  
print("Hiding CTF flag...")
flag_http_payload = (
    "POST /login HTTP/1.1\r\n"
    "Host: secure.idn\r\n"
    "Content-Type: application/x-www-form-urlencoded\r\n"
    "Content-Length: 58\r\n"
    "User-Agent: Mozilla/5.0 (Military Browser)\r\n"
    "\r\n"
    "username=admin&password=SEEN{P4ssw0rd_In_Pl4intext_Is_Bad_Mmmkay}"
)

flag_http = Ether(src=random_mac(), dst=random_mac()) / IP(src=random_ipv4(), dst=random_ipv4()) / TCP(sport=random.randint(1024, 65535), dport=80, flags="PA") / Raw(load=flag_http_payload)
packets.append(flag_http)

# --- 7. Add some legitimate-looking traffic for cover ---
print("Generating cover traffic...")
for i in range(300):
    # Normal web browsing
    normal_http = Ether(src=random_mac(), dst=random_mac()) / IP(src=random_ipv4(), dst=random_ipv4()) / TCP(sport=random.randint(1024, 65535), dport=80, flags="PA") / Raw(load="GET / HTTP/1.1\r\nHost: www.example.com\r\n\r\n")
    packets.append(normal_http)

# Shuffle packets for more realistic timing
random.shuffle(packets)

# --- 8. Final: Write with Explicit Linktype & Metadata ---
print("Writing PCAP file...")
try:
    wrpcap("traffic.pcap", packets)
    print(f"✅ SUCCESS! ✅")
    print(f"📁 Generated: traffic.pcap")
    print(f"🎯 Mission: {MISSION_ID} - {OPERATION_NAME}")
    print(f"📡 Sector: {SECTOR}")
    print(f"⏱️  Timestamp: {datetime.fromtimestamp(TIMESTAMP)}")
    print(f"📊 Total Packets: {len(packets)}")
    print(f"⚡ Transmission Rate: {PACKETS_PER_SEC} packets/sec")
    print(f"🔐 Encryption: AES-256-CTR + Obfuscation + AI Noise")
    print(f"🧠 Simulated: {len(packets)} packets of futuristic military traffic")
    print(f"🌌 Note: This file is for training AI threat models only. Unauthorized use is prohibited.")
except Exception as e:
    print(f"❌ Error writing PCAP: {e}")