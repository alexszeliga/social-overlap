SELECT 'CREATE DATABASE social_overlap_test'
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'social_overlap_test')\gexec
