#https://www.reddit.com/r/adventofcode/comments/kcr1ct/2020_day_14_solutions/gfshjtl/?utm_source=reddit&utm_medium=web2x&context=3
#i used this as a reference to test against my input

import fileinput
def write(memory, mask, address, value):
    if "X" in mask:
        i = mask.index("X")
        write(memory, mask[:i] + "0" + mask[i+1:], address, value)
        write(memory, mask[:i] + "1" + mask[i+1:], address, value)
    else:
        memory[int(mask, 2) | address] = value


m1 = {}
m2 = {}
mask = None

for line in fileinput.input():
    key, value = line.strip().split(" = ")
    if key == "mask":
        mask = value
    else:
        address = int(key[4:-1])
        value = int(value)

        m1[address] = value \
            & int(mask.replace("1", "0").replace("X", "1"), 2) \
            | int(mask.replace("X", "0"), 2)

        address &= int(mask.replace("0", "1").replace("X", "0"), 2)
        write(m2, mask, address, value)

print (len(m2))

print(sum(m1.values()))
print(sum(m2.values()))