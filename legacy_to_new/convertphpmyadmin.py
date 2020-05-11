# add INSERT statement after 200 lines
insert_stmt = "INSERT INTO `v3_produto` (id, codigo, nome, medidas, inativo) VALUES"

with open("rawv2produto.sql", encoding="utf-8") as inp, open("insert_v3_produto.sql", 'w', encoding='utf-8') as outp:
    ct = 0
    for line in inp:
        if ct % 200 == 0:
            print(insert_stmt, file=outp)
        args = line.split(', ')
        print("({}, {}, {}, {}, 0)".format(args[0], args[1], args[2], args[5]), end="", file=outp)
        ct += 1
        if ct % 200 == 0:
            print(";", file=outp)
        else:
            print(",", file=outp)

# replace final , with ;
outputfile = open("insert_v3_produto.sql", encoding="utf-8")
output = outputfile.read()
output = output[:-2] + ";"
outputfile.close()

with open("insert_v3_produto.sql", "w", encoding="utf-8") as outp:
    print(output, file=outp)
    
