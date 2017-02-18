#!/bin/bash

gs -sDEVICE=pdfwrite -dSAFER -o /Applications/MAMP/htdocs/bq-tools/bq-xmltransform/pdf-split/2.1.p%d.pdf /Applications/MAMP/htdocs/bq/pdfs/2.1.pdf
gs -sDEVICE=pdfwrite -dSAFER -o /Applications/MAMP/htdocs/bq-tools/bq-xmltransform/pdf-split/2.2.p%d.pdf /Applications/MAMP/htdocs/bq/pdfs/2.2.pdf
