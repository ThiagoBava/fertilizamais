-- ===============================
-- SCRIPT DE ATUALIZAÇÃO DO BANCO fertilizaMais.db
-- Adiciona o campo tipoCultura na tabela analises
-- ===============================

-- 1️⃣ Verifica se a tabela 'analises' existe
SELECT name FROM sqlite_master WHERE type='table' AND name='analises';

-- 2️⃣ Cria a tabela caso ainda não exista (segurança extra, não altera se já existir)
CREATE TABLE IF NOT EXISTS analises (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario TEXT,
    periodo TEXT,
    anoAgricola TEXT,
    talhao TEXT,
    grid TEXT,
    dataAnalise TEXT,
    numTratamentos INTEGER,
    numRepeticoes INTEGER,
    numParcelas INTEGER
);

-- 3️⃣ Verifica se a coluna 'tipoCultura' já existe
PRAGMA table_info(analises);

-- 4️⃣ Se o campo ainda não existe, adiciona
ALTER TABLE analises ADD COLUMN tipoCultura TEXT;

-- 5️⃣ Confirma que a nova coluna foi criada
PRAGMA table_info(analises);

-- 6️⃣ Exibe as primeiras 5 linhas para testar se está tudo certo
SELECT id, usuario, periodo, anoAgricola, talhao, tipoCultura FROM analises LIMIT 5;

-- ===============================
-- FIM DO SCRIPT
-- ===============================